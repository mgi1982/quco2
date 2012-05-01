<?php

namespace Quco2\Bundle\MetricsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('Quco2MetricsBundle:Default:index.html.twig', array('name' => $name));
    }
}
