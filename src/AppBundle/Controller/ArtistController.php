<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Artist;
use AppBundle\Event\ArtistEvent;
use AppBundle\Events\ArtistEvents;
use AppBundle\Form\ArtistFormType;
use AppBundle\Repository\ArtistRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArtistController extends Controller
{
    private function getMagicNumbers()
    {
        $cache = $this->get('cache.app');

        $cachedNumbers = $cache->getItem('magicNumbers');

        //Si pas présent dans le cache
        if (!$cachedNumbers->isHit()) {

            sleep(5);

            $numbers = [
                rand(1, 42),
                rand(1, 42),
                rand(1, 42),
            ];

            $cachedNumbers->set($numbers);
            $cache->save($cachedNumbers);
        }

        return $cachedNumbers->get();
    }


    /**
     * @Route(path="/artists")
     * @Route(
     *     path="/artists/{decade}0s",
     *     name="app_artist_index_decade",
     *     requirements={"decade": "[0-9]{3,3}"}
     * )
     */
    public function indexAction(Request $request, $decade = null)
    {
        $doctrine = $this->getDoctrine();

        /** @var ArtistRepository $artistRepo */
        $artistRepo = $doctrine->getRepository('AppBundle:Artist');

        if (null === $decade) {
            $artists = $artistRepo->findAll();

        } else {
            $decade *= 10;
            $artists = $artistRepo->findByDecade($decade);
        }

        $artistViewCount = $request->getSession()->get('artistViewCount', 0);

        return $this->render('artist/index.html.twig', [
            'decade' => $decade,
            'artists' => $artists,
            'artistViewCount' => $artistViewCount,
        ]);
    }

    /**
     * @Route(
     *     path="/artist/{id}",
     *     requirements={"id": "[0-9]+"}
     * )
     */
    public function showAction(Artist $artist)
    {
        $bandsInTownClient = $this->get('app.bandsintown.client');
        $tourDates = $bandsInTownClient->getTourDates($artist);

        $this->get('event_dispatcher')->dispatch(ArtistEvents::SHOW, new ArtistEvent($artist));

        return $this->render('artist/show.html.twig', ['artist' => $artist, 'tourDates' => $tourDates]);
    }

    /**
     * @Route(path="/artists/search")
     */
    public function searchAction()
    {
        $artists = [];

        return new JsonResponse($artists);
    }

    /**
     * @Route(path="/artist/new")
     */
    public function newAction()
    {
        return new Response('Nouvel artiste !');
    }

    /**
     * @Route(path="/artist/{id}/edit")
     */
    public function editAction(Artist $artist, Request $request)
    {
        $bandsInTownClient = $this->get('app.bandsintown.client');
        $tourDates = $bandsInTownClient->getTourDates($artist);

        $form = $this->createForm(ArtistFormType::class, $artist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $doctrine = $this->getDoctrine();
            $em = $doctrine->getManager();

            $em->persist($artist);
            $em->flush();

            $this->get('event_dispatcher')->dispatch(ArtistEvents::EDIT, new ArtistEvent($artist));
            $this->get('mailer');

            //La redirection est commentée pour qu'on puisse voir l'email dans la Debug Toolbar
            //return $this->redirectToRoute('app_artist_show', ['id' => $artist->getId()]);
        }

        return $this->render('artist/edit.html.twig', [
            'artist' => $artist,
            'artistForm' => $form->createView(),
            'tourDates' => $tourDates,
        ]);
    }
}