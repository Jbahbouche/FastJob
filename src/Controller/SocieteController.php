<?php

namespace App\Controller;

use App\Entity\Societe;
use App\Entity\User;
use App\Form\SocieteType;
use App\Repository\AnnonceRepository;
use App\Repository\SocieteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/societe')]
class SocieteController extends AbstractController
{
    #[Route('/', name: 'app_societe_index', methods: ['GET'])]
    public function index(SocieteRepository $societeRepository): Response
    {
        if (!($this->getUser()->getRoles()[0] == "ROLE_ADMIN")){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('societe/index.html.twig', [
            'societes' => $societeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_societe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SocieteRepository $societeRepository, UserRepository $userRepository): Response
    {
        if ($this->getUser()->getCandidat() || $this->getUser()->getSociete() || $this->getUser()->getRoles()[0] == "ROLE_CANDIDAT"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $societe = new Societe();
        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $logo = $form->get("logo")->getData();
            if($logo)
            {
                $nomImage = date("YmdHis")."-".uniqid()."-".$logo->getClientOriginalName();
                $logo->move($this->getParameter('logo'),$nomImage);
                $societe->setLogo($nomImage);
            }
            $societeRepository->add($societe, true);
            $this->getUser()->setSociete($societe);
            $userRepository->add($this->getUser(), true);

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('societe/new.html.twig', [
            'societe' => $societe,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_societe_show', methods: ['GET'])]
    public function showSociete(User $user, AnnonceRepository $annonceRepository): Response
    {
        /* TODO PAGE404*/
        $societe= $user->getSociete();
        $id=$this->getUser()->getSociete();
        $annonces = $annonceRepository->findBy(['societe'=> $id]);
        return $this->render('societe/show.html.twig', [
            'societe' => $societe,
            'annonces' => $annonces
        ]);
    }
    #[Route('/{id}/edit', name: 'app_societe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Societe $societe, SocieteRepository $societeRepository): Response
    {
        if ($this->getUser()->getCandidat() || $this->getUser()->getRoles()[0] == "ROLE_CANDIDAT"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        if($this->getUser()->getSociete() != $societe){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $societe2 = new Societe;
        $societe2 = $societe; 
        $logo = $societe->getLogo();
        $societe2->setLogo(null);
        $form = $this->createForm(SocieteType::class, $societe2);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newlogo = $form->get("logo")->getData();
            if($newlogo)
            {
                $nomImage = date("YmdHis")."-".uniqid()."-".$newlogo->getClientOriginalName();
                $newlogo->move($this->getParameter('logo'),$nomImage);
                $societe->setLogo($nomImage);
            } else {
                $societe->setLogo($logo);
            }
            $societeRepository->add($societe, true);
            return $this->showSociete($this->getUser());
        }
        return $this->renderForm('societe/edit.html.twig', [
            'societe' => $societe,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_societe_delete', methods: ['POST'])]
    public function delete(Request $request, Societe $societe, SocieteRepository $societeRepository): Response
    {
        if ($this->getUser()->getCandidat()  || $this->getUser()->getRoles()[0] == "ROLE_CANDIDAT"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        if ($this->isCsrfTokenValid('delete'.$societe->getId(), $request->request->get('_token'))) {
            $societeRepository->remove($societe, true);
        }

        return $this->redirectToRoute('app_societe_index', [], Response::HTTP_SEE_OTHER);
    }
}
