<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Controller to render a basic "homepage".
 */
class FrontendController extends AbstractController
{
    /**
     * @Route("/")
     * @param SerializerInterface $serializer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepage(SerializerInterface $serializer)
    {
        return $this->render('frontend/homepage.html.twig', [
            'user' => $serializer->serialize($this->getUser(), "jsonld")
        ]);
    }
}
