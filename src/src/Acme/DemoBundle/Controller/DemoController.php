<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DemoController extends Controller
{
    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {
    	$this->getRequest()->getSession()->setFlash('marcos', 'Rulezzz');
        return array('name' => $name);
    }
    
    /**
     * @Route("/fuckoff/{mate}.{_format}/{insult}", defaults={"insult" = "Standart Insult", "_format"="html"}, requirements={"_format"="xml|html|json"}, name="_demo_fuckoff")
     * @Template()
     */
    public function fuckoffAction($mate, $insult)
    {
    	/*return $this->render('AcmeDemoBundle:Demo:hello.html.twig', array(
			'mate' => $mate,
    		'insult' => $insult,
    	));*/
    	//return $this->forward('AcmeDemoBundle:Demo:Hello', array('name' => 'Marcos'));
    	return array('mate' => $mate, 'insult' => $insult, 'iterate' => range(1, 30, 2));
    }

    /**
     * @Route("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->get('form.factory')->create(new ContactType());

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                // .. setup a message and send it
                // http://symfony.com/doc/current/cookbook/email.html

                $this->get('session')->setFlash('notice', 'Message sent!');

                return new RedirectResponse($this->generateUrl('_demo'));
            }
        }

        return array('form' => $form->createView());
    }
}
