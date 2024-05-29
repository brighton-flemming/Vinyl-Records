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
        return new Response('
        <strong>This is the new vinyl records app</strong>
        ');
    }
}
