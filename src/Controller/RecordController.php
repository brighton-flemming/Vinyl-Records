<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



class RecordController extends AbstractController
{
    #[Route('/record', name: 'app_record')]
    public function index(): Response
    {
        $songCount = 80;

        $myAlbum = [
            'name' => "Inner love",
            'artist' => "MAGIC!",
            'likes' => 21387400,
            'favouriteTrack' => "Truly Happy"
        ];

        return $this-> render('record/homepage.html.twig', [
            'numberOfSongs' => $songCount,
            'myAlbum' => $myAlbum,
        ]);
    }
}
