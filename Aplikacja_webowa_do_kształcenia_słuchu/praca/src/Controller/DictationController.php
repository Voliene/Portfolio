<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DictationController extends AbstractController
{
    #[Route('/dictation', name: 'dictation')]
    public function index(SessionInterface $session): Response
    {
        $selectedFile = $session->get('selected_music_file', null);

        return $this->render('dictation.html.twig', [
            'selectedFile' => $selectedFile
        ]);
    }
}
