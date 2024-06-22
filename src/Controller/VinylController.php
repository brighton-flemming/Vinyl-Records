<?php

namespace App\Controller;

use App\Repository\VinylRepository;
use App\Service\IdManager;
use App\Entity\Vinyl;
use App\Form\DeleteVinylType;
use App\Form\VinylType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



class VinylController extends AbstractController
{

    #[Route('/vinyl/new', name: 'vinyl_new', methods: ['GET','POST'])]
    public function new_vinyl (Request $request, EntityManagerInterface $entityManager, IdManager $idManager): Response
    {

        $Vinyl = new Vinyl();
        $Vinyl->setCreatedAt(new DateTimeImmutable());
        $Form = $this->createForm(VinylType::class, data: $Vinyl);
        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {

            $nextId = $idManager->getNextId();
            $Vinyl->setId($nextId);

            $entityManager->persist($Vinyl);
            $entityManager->flush();

            return $this->redirectToRoute(route: 'app_vinyl_new_success', parameters: array('id' => $Vinyl->getId()));

        }

        return $this->render('record/vinyl_new.html.twig', [
            'Form' => $Form,
            'controller_name' => 'VinylController',
        ]);
    }
    #[Route('/vinyl/new/{id<\d+>}', name: 'app_vinyl_new_success', methods: ['GET'])]
    public function new_success(int $id, EntityManagerInterface $entityManager): Response
    {

        $Vinyl = $entityManager->getRepository(Vinyl::class)->find($id);

        if (!$Vinyl) {
            throw $this->createNotFoundException(
                'No record found for id '.$id
            );
        }

        return $this->render('record/vinyl_new_success.html.twig', [
            'vinyl' => $Vinyl,
        ]);
    }

    #[Route('/vinyl/delete', name: 'vinyl_delete', methods: ['GET','DELETE', 'POST'])]
     public function delete_vinyl (Request $request, EntityManagerInterface $entityManager): Response
    {

        $Form = $this->createForm(DeleteVinylType::class);
        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {
            $data = $Form->getData();
            $Vinyl = $entityManager->getRepository(Vinyl::class)->findOneBy([
                'record_name' => $data->getRecordName(),
                'artist_name' => $data->getArtistName(),
            ]);

            if(!$Vinyl) {
                throw $this->createNotFoundException('No vinyl record found for record name '.$data->getRecordName().' and artist name.'.$data->getArtistName());
            }

            $entityManager->remove($Vinyl);
            $entityManager->flush();

            return $this->redirectToRoute('app_home' );


        }

        return $this->render('record/delete.html.twig', [
            'Form'=> $Form->createView(),
        ]);

    }

    #[Route('/vinyl/show/{id}', name: 'vinyl_show', methods: ['GET'])]
      public function show(int $id, EntityManagerInterface $entityManager, VinylRepository $vinylRepository): Response
    {
        $vinyl = $entityManager->getRepository(Vinyl::class)->find($id);

        if (!$vinyl) {
            throw $this->createNotFoundException('No vinyl found for id ' . $id);
        }

        $nextVinyl = $vinylRepository->findOneBy(['id' => $vinyl->getId() + 1]);

        if (!$nextVinyl) {
            $nextVinyl = $vinylRepository->findOneBy([], ['id' => 'ASC']);
        }

        $previousVinyl = $vinylRepository->findOneBy(['id' => $vinyl->getId() - 1]);

        if (!$previousVinyl) {
            $previousVinyl = $vinylRepository->findOneBy([], ['id' => 'DESC']);
        }


    return $this->render('record/show.html.twig', [
        'vinyl' => $vinyl,
        'nextVinyl' => $nextVinyl,
        'previousVinyl' => $previousVinyl,
    ]);

}



}


