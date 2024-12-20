<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function profile(): Response
    {
        if ($this->isGranted('ROLE_BANNED')) {
            return $this->redirectToRoute('banned');
        }

        return $this->render('auth/profile.html.twig');
    }
}