<?php

namespace App\Controller;


use App\Form\SearchType;
use App\Repository\VinylRepository;


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
    public function new_vinyl (Request $request, EntityManagerInterface $entityManager ): Response
    {
        $Vinyl = new Vinyl();
        $Vinyl->setCreatedAt(new DateTimeImmutable());
        $Form = $this->createForm(VinylType::class, data: $Vinyl);
        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {


            $lastRecord = $entityManager->getRepository(Vinyl::class)->findOneBy([], ['record_sequence' => 'desc']);
            if ($lastRecord) {
                $Vinyl->setRecordSequence($lastRecord->getRecordSequence() + 1);
            } else {
                $Vinyl->setRecordSequence(1);
            }

            $entityManager->persist($Vinyl);
            $entityManager->flush();

            return $this->redirectToRoute(route: 'app_vinyl_new_success', parameters: array('record_sequence' => $Vinyl->getRecordSequence()));
        }

        return $this->render('record/vinyl_new.html.twig', [
            'Form' => $Form,
            'controller_name' => 'VinylController',
        ]);
    }

    #[Route('/vinyl/new/{record_sequence}', name: 'app_vinyl_new_success', methods: ['GET', 'POST'])]
    public function new_success(int $record_sequence, EntityManagerInterface $entityManager): Response
    {

        $Vinyl = $entityManager->getRepository(Vinyl::class)->find($record_sequence);

        if (!$Vinyl) {
            throw $this->createNotFoundException(
                'No record found for record sequence '.$record_sequence
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

    #[Route('/vinyl/show/{record_sequence}', name: 'vinyl_show', methods: ['GET'])]

      public function show(int $record_sequence, EntityManagerInterface $entityManager, VinylRepository $vinylRepository): Response

    {
        $vinyl = $entityManager->getRepository(Vinyl::class)->find($record_sequence);

        if (!$vinyl) {
            throw $this->createNotFoundException('No vinyl found for record sequence ' . $record_sequence);
        }


        $nextVinyl = $vinylRepository->findOneBy(['record_sequence' => $vinyl->getRecordSequence() + 1]);

        if (!$nextVinyl) {
            $nextVinyl = $vinylRepository->findOneBy([], ['record_sequence' => 'ASC']);
        }

        $previousVinyl = $vinylRepository->findOneBy(['record_sequence' => $vinyl->getRecordSequence() - 1]);

        if (!$previousVinyl) {
            $previousVinyl = $vinylRepository->findOneBy([], ['record_sequence' => 'DESC']);
        }


    return $this->render('record/show.html.twig', [
        'vinyl' => $vinyl,
        'nextVinyl' => $nextVinyl,
        'previousVinyl' => $previousVinyl,

    ]);

}

#[Route ('/search', name:'search', methods: ['GET', 'POST'])]
public function search(Request $request ,VinylRepository $vinylRepository ): Response
{
    $form = $this->createForm(SearchType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $query = $form->get('query')->getData();
        $vinyls = $vinylRepository->search($query);

        return $this->render('vinyl/search.html.twig', [
            'vinyls' => $vinyls,
        ]);
    }
    return $this->render('vinyl/search_form.html.twig', [
        'form' => $form->createView(),
    ]);

}
}


