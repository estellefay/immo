<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Repository\PropertyRepository;



class HomeController  extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @return Response
     *  
     */
    public function index(PropertyRepository $repository): Response
    {
        $properties = $repository->findLastest();


        return $this->render('pages/home.html.twig', [
            'properties' => $properties
        ]);
    }
}

// property.index