<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 15/12/2016
 * Time: 11:10
 */

namespace AppBundle\EventListener;


use Symfony\Component\HttpFoundation\RequestStack;

class IncrementViewCountListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onShow()
    {
        $request = $this->requestStack->getMasterRequest();
        $artistViewCount = $request->getSession()->get('artistViewCount', 0);
        $artistViewCount++;
        $request->getSession()->set('artistViewCount', $artistViewCount);
    }
}
