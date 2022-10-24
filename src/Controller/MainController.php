<?php

namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/parametres', name: 'app_parametres')]
    public function parametres(): Response
    {   
        return $this->render('parametres/index.html.twig', [
            'user'=> $this->getUser()
        ]);
    }
    #[Route('/parametres/delete', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, UserRepository $userRepository): Response
    {
        $user= $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {

            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);
    }
}
