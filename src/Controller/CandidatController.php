<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Form\Candidat1Type;
use App\Repository\UserRepository;
use App\Repository\CandidatRepository;
use App\Repository\CompetenceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/candidat')]
class CandidatController extends AbstractController
{
    #[Route('/', name: 'app_candidat_index', methods: ['GET'])]
    public function index(CandidatRepository $candidatRepository): Response
    {
        if (!($this->getUser()->getRoles()[0] == "ROLE_SOCIETE")){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_candidat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CandidatRepository $candidatRepository, UserRepository $userRepository): Response
    {
        
        if ($this->getUser()->getCandidat() || $this->getUser()->getSociete() || $this->getUser()->getRoles()[0] == "ROLE_SOCIETE"){
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pdf = $form->get("cvPDF")->getData();
            if($pdf)
            {
                $nomImage = date("YmdHis")."-".uniqid()."-".$pdf->getClientOriginalName();
                $pdf->move($this->getParameter('cvpdf'),$nomImage);
                $candidat->setCvPDF($nomImage);
            }
            $candidatRepository->add($candidat, true);
            $this->getUser()->setCandidat($candidat);
            $userRepository->add($this->getUser(), true);

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidat/new.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }

    
    #[Route('/{id}', name: 'app_candidat_show', methods: ['GET'])]
    public function showCandidat(User $user, CandidatRepository $candidatRepository, CompetenceRepository $competenceRepository): Response
    {
        $candidat=$candidatRepository->findById($this->getUser()->getCandidat()->getId())[0];
        return $this->render('user/showCandidat.html.twig', [
            'user' => $user,
            'candidat' => $candidat,
            'competences' => $competenceRepository->findAll(),

        ]);
    }
    #[Route('/annoncecandidat/{id}', name: 'app_candidat_annonce_show', methods: ['GET'])]
    public function showCandidatAnnonce(User $user, CandidatRepository $candidatRepository,$id, CompetenceRepository $competenceRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id)->getCandidat()->getId();

        $candidat= $candidatRepository->findBy(['id' => $user])[0];
        return $this->render('user/showCandidatAnnonce.html.twig', [
            'user' => $user,
            'candidat' => $candidat,
            'competences' => $competenceRepository->findAll(),

        ]);
    }

    #[Route('/{id}/edit', name: 'app_candidat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidat $candidat, CandidatRepository $candidatRepository): Response
    {
        $candidat2 = new Candidat;
        $candidat2 = $candidat; 
        $CVPDF = $candidat->getCvPDF();
        $candidat2->setCvPDF(null);
        $form = $this->createForm(CandidatType::class, $candidat2);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pdf = $form->get("cvPDF")->getData();
            if($pdf)
            {
                $nomImage = date("YmdHis")."-".uniqid()."-".$pdf->getClientOriginalName();
                $pdf->move($this->getParameter('cvpdf'),$nomImage);
                $candidat->setCvPDF($nomImage);
            } else {
                $candidat->setCvPDF($CVPDF);
            }
            $candidatRepository->add($candidat, true);
            return $this->redirectToRoute('app_candidat_show', ['id' => $this->getUser()->getId()]);
        }
        return $this->renderForm('candidat/edit.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/competence', name: 'app_candidat_competence', methods: ['GET', 'POST'])]
    public function competence(Request $request, Candidat $candidat, CandidatRepository $candidatRepository): Response
    {

        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $candidatRepository->add($candidat, true);
            return $this->redirectToRoute('app_candidat_show', ['id' => $this->getUser()->getId()]);
        }
        return $this->renderForm('candidat/edit.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidat_delete', methods: ['POST'])]
    public function delete(Request $request, Candidat $candidat, CandidatRepository $candidatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidat->getId(), $request->request->get('_token'))) {
            $candidatRepository->remove($candidat, true);
        }
        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }
    
}
