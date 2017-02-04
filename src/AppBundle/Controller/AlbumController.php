<?php

namespace AppBundle\Controller;

use Elastica\Query;
use Elastica\Suggest;
use Elastica\Type;
use FOS\ElasticaBundle\HybridResult;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AlbumController extends Controller
{
    /**
     * @Route(path="/album/{id}", requirements={"id": "\d+"})
     */
    public function showAction($id)
    {
        return new Response(sprintf('Détail album %s', $id));
    }

    /**
     * @Route(path="/album/search")
     */
    public function searchAction()
    {
        $im = $this->container->get('fos_elastica.index_manager');
        /** @var Type $index */
        $index = $im->getIndex('app')->getType('album');

        $fieldQuery = [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['artist.name' => 'Floyd']],
                        ['match' => ['artist.genres.name' => 'anime']],
                    ],
                    'must' => [
                        ['range' => ['releaseDate' => ['from' => 1970, 'to' => 1989]]],
                    ],
                    'must_not' => [
                        ['term' => ['id' => 11]],
                    ],
                ],
            ],
        ];

        $albums = $index->search($fieldQuery);

        foreach ($albums as $album) {
            dump($album->getScore());
        }

        $finder = $this->container->get('fos_elastica.finder.app.album');
        $albums = $finder->find($fieldQuery);

        /** @var HybridResult $album */
        foreach ($albums as $album) {
            dump($album->getResult()->getScore());
            dump($album->getResult()->getScore());
        }

        dump('--- HYBRID ---');

        $albums = $finder->findHybrid($fieldQuery);

        /** @var  $album */
        foreach ($albums as $album) {
            dump($album);
        }

        dump('--- OOP style ---');

        $boolQuery = new Query\BoolQuery();
        $boolQuery->addShould(new Query\Match('artist.name', 'Floyd'))
                  ->addShould(new Query\Match('artist.genres.name', 'anime'))
                  ->addMust(new Query\Range('releaseDate', ['from' => 1970, 'to' => 1989]))
                  ->addMustNot(new Query\Term(['id' => 11]));

        $albums = $finder->find($fieldQuery);

        foreach ($albums as $album) {
            dump($album->getTitle());
        }

        exit(); //return new JsonResponse($albums);
    }

    /**
     * @Route(path="/album/suggest/{q}")
     */
    public function suggestAction($q)
    {
        /*
        POST /app/_suggest
        {
           "suggestion": {
              "text": "198",
              "completion": {
                 "fuzzy": {
                    "fuzziness": 1
                 },
                 "field": "suggest"
              }
           }
        }

        POST app/_search?size=0
        {
            "_source": {"includes": ["id", "name", "creationYear"]},
            "suggest": {
                "artist_suggest" : {
                    "prefix" : "Si",
                    "completion" : {
                        "field" : "suggest"
                    }
                }
            }
        }

        POST /app/_suggest
        {
           "suggestion": {
              "text": "nic",
              "completion": {
                 "fuzzy": {
                    "fuzziness": 1
                 },
                 "field": "suggest",
                   "contexts": {
                        "genre": [ "Acoustic" ]
                    }
              }

           }
        }

        */


        $suggest = new Suggest();

        $completion = new Suggest\Completion('artist_suggest', 'suggest');
        $completion->setText($q);
        $completion->setFuzzy(['fuzziness' => 1]);
        $suggest->addSuggestion($completion);

        $phrase = new Suggest\Phrase('artist_suggest', 'suggest');
        $phrase->setText($q)->setMaxErrors(3);
        //$suggest->addSuggestion($phrase);

        $term = new Suggest\Term('artist_suggest', 'suggest');
        $term->setText($q);
        //$suggest->addSuggestion($term);

        /** @var Type $index */
        $res = $this->get('fos_elastica.index.app.artist')->search($suggest)->getSuggests();

        dump($res['artist_suggest']);

        $completion = new Suggest\Completion('artist_suggest', 'suggest');
        $completion->setText($q);
        $res = $this->get('fos_elastica.index.app.artist')->search($suggest)->getSuggests();

        $finder = $this->container->get('fos_elastica.finder.app.artist');
        $res = $finder->find($suggest);

        dump($res);

        exit();
    }
}
