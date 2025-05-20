<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SingController extends AbstractController
{
    #[Route('/sing', name: 'sing')]
    public function index(): Response
    {
        return $this->render('sing.html.twig');
    }
}
