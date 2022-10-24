<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/candidature')]
class CandidatureController extends AbstractController
{
    #[Route('/', name: 'app_candidature_index', methods: ['GET'])]
    public function index(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }
    #[Route('/mescandidatures', name: 'app_mes_candidatures', methods: ['GET'])]
    public function mesCandidatures(CandidatureRepository $candidatureRepository): Response
    {
        if ($this->getUser()->getSociete() || $this->getUser()->getRoles()[0] == "ROLE_SOCIETE"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('candidature/indexCandidat.html.twig', [
            'candidatures' => $candidatureRepository->findBy(['candidat'=> $this->getUser()->getCandidat()]),
        ]);
    }

    #[Route('/{id}', name: 'app_candidater', methods: ['GET', 'POST'])]
    public function candidater(CandidatureRepository $candidatureRepository, $id, AnnonceRepository $annonceRepository, Request $request,): Response
    {
        if ($this->getUser()->getSociete() || $this->getUser()->getRoles()[0] == "ROLE_SOCIETE"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $annonce = $annonceRepository->findBy(['id' => $id])[0];
        $candidat= $this->getUser()->getCandidat();
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);
        $candidature->setAnnonce($annonce);
        $candidature->setCandidat($candidat);
        $candidature->setConsulte(false);
        $candidature->setRetenu(true);
        $poste = $annonce->getTitre();
        $entreprise = $annonce->getSociete()->getNom();
        $candidature->setCreatedAt(new DateTimeImmutable());
        if ($form->isSubmitted() && $form->isValid()) {

            $candidatureRepository->add($candidature, true);

            return $this->redirectToRoute('app_annonce_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('candidature/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
            'id' => $id,
            'poste' => $poste,
            'entreprise' => $entreprise
        ]);
    }


    #[Route('/{id}', name: 'app_candidature_show', methods: ['GET'])]
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

}
