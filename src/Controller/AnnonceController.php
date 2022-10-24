<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use App\Repository\SocieteRepository;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    #[Route('/', name: 'app_annonce_index', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }
    #[Route('/mesannonces', name: 'app_mes_annonces', methods: ['GET'])]
    public function mesAnnonces(AnnonceRepository $annonceRepository): Response
    {
        if ($this->getUser()->getCandidat() || $this->getUser()->getRoles()[0] == "ROLE_CANDIDAT"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $id=$this->getUser()->getSociete();
        $annonces = $annonceRepository->findBy(['societe'=> $id]);
        return $this->render('annonce/indexMesAnnonces.html.twig', [
            'annonces'=> $annonces,
            'societe' => $id
        ]);
    }

    #[Route('/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnnonceRepository $annonceRepository, SocieteRepository $societeRepository): Response
    {
        if ($this->getUser()->getCandidat() || $this->getUser()->getRoles()[0] == "ROLE_CANDIDAT"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $societe = $societeRepository->findById($this->getUser()->getSociete()->getId())[0];
        $annonce = new Annonce();
        $annonce->setDescription($societe->getDescription());
        $annonce->setCreatedAt(new DateTimeImmutable());
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setSociete($this->getUser()->getSociete());
            $annonceRepository->add($annonce, true);

            return $this->redirectToRoute('app_mes_annonces', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
            'societe' => $societe
        ]);
    }

    #[Route('/{id}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce, SocieteRepository $societeRepository, CandidatureRepository $candidatureRepository ): Response
    {
        $societe = $societeRepository->findById($annonce->getSociete()->getId())[0];
        $dejaPostule =false;
        if ($this->getUser()->getCandidat() || $this->getUser()->getRoles()[0] == "ROLE_CANDIDAT"){
            $existe = $candidatureRepository->findBy(['annonce' => $annonce, 'candidat' => $this->getUser()->getCandidat()]);
            if ($existe){
                $dejaPostule =true;
            }
        }
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'societe' =>$societe,
            'dejaPostule' => $dejaPostule
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository, SocieteRepository $societeRepository): Response
    {
        if ($this->getUser()->getCandidat() || $this->getUser()->getRoles()[0] == "ROLE_CANDIDAT"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $societe = $societeRepository->findById($this->getUser()->getSociete()->getId())[0];
        if($annonce->getSociete() != $societe){
            return $this->redirectToRoute('app_mes_annonces', [], Response::HTTP_SEE_OTHER);
        }
        
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonceRepository->add($annonce, true);
            return $this->redirectToRoute('app_mes_annonces', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
            'societe' => $societe
        ]);
    }

    #[Route('/{id}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository, SocieteRepository $societeRepository): Response
    {
        if ($this->getUser()->getCandidat() || $this->getUser()->getRoles()[0] == "ROLE_CANDIDAT"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $societe = $societeRepository->findById($this->getUser()->getSociete()->getId())[0];
        if($annonce->getSociete() != $societe){
            return $this->redirectToRoute('app_mes_annonces', [], Response::HTTP_SEE_OTHER);
        }
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $annonceRepository->remove($annonce, true);
        }

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/candidat/{id}', name: 'app_annonce_candidat_show', methods: ['GET'])]
    public function annonceCandidat(Annonce $annonce, SocieteRepository $societeRepository, CandidatureRepository $candidatureRepository ): Response
    {
        if ($this->getUser()->getCandidat() || $this->getUser()->getRoles()[0] == "ROLE_CANDIDAT"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $candidatures = $candidatureRepository->findBy(['annonce' => $annonce ]);

        return $this->render('annonce/showCandidats.html.twig', [
            'annonce' => $annonce,
            'candidatures' => $candidatures
        ]);
    }
}

