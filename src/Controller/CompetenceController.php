<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetenceController extends AbstractController
{
    #[Route('/competence', name: 'app_competence')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }
}
