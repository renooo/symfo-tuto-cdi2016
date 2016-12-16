<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CollectionController extends Controller
{
    /**
     * @Route(path="/collection/{user_id}")
     * @Route(path="/collection", name="app_collection_index_me")
     */
    public function indexAction($user_id = null)
    {
        return new Response('Collection utilisateur');
    }
}
