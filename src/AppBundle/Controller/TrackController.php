<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TrackController extends Controller
{
    /**
     * @Route(path="/track/{id}")
     */
    public function showAction($id)
    {
        return new Response('Détails morceau');
    }
}
