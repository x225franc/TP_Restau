<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/access-denied', name: 'access_denied')]
    public function accessDenied(): Response
    {
        return $this->render('security/access_denied.html.twig');
    }

    #[Route('/banned', name: 'banned')]
    public function banned(): Response
    {
        if (!$this->getUser() || !$this->isGranted('ROLE_BANNED')) {
            return $this->redirectToRoute('home');
        }

        return $this->render('security/banned.html.twig');
    }
}