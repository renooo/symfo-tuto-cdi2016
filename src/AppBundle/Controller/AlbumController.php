<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AlbumController extends Controller
{
    /**
     * @Route(path="/album/{id}")
     */
    public function showAction($id)
    {
        return new Response(sprintf('Détail album %s', $id));
    }
}
