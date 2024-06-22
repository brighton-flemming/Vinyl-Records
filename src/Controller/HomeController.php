<?php

namespace App\Controller;

use App\Entity\Vinyl;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('', name: 'app_home', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $Vinyl = $entityManager->getRepository(Vinyl::class)->findAll();

        return $this->render('home/homepage.html.twig', [
            'controller_name' => 'HomeController',
            'Vinyl' => $Vinyl,
        ]);
    }
}
