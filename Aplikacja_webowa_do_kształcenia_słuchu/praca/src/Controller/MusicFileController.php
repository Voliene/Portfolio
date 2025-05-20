<?php

namespace App\Controller;

use App\Entity\MusicFile;
use App\Form\MusicFileType;
use App\Repository\MusicFileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/music/file')]
class MusicFileController extends AbstractController
{
    #[Route('/', name: 'app_music_file_index', methods: ['GET'])]
    public function index(MusicFileRepository $musicFileRepository): Response
    {
        return $this->render('music_file/index.html.twig', [
            'music_files' => $musicFileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_music_file_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $musicFile = new MusicFile();
        $form = $this->createForm(MusicFileType::class, $musicFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($musicFile);
            $entityManager->flush();

            return $this->redirect('http://localhost:50929/dictation');
        }

        return $this->render('music_file/new.html.twig', [
            'music_file' => $musicFile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_music_file_show', methods: ['GET'])]
    public function show(MusicFile $musicFile): Response
    {
        return $this->render('music_file/show.html.twig', [
            'music_file' => $musicFile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_music_file_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MusicFile $musicFile, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MusicFileType::class, $musicFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_music_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('music_file/edit.html.twig', [
            'music_file' => $musicFile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_music_file_delete', methods: ['POST'])]
    public function delete(Request $request, MusicFile $musicFile, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$musicFile->getId(), $request->request->get('_token'))) {
            $musicFile->setFileName(null);
            $entityManager->remove($musicFile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_music_file_index');
    }



    #[Route('/music/file/select/{id}', name: 'app_music_file_select')]
    public function selectFile(int $id, SessionInterface $session, MusicFileRepository $repository): Response
    {
        $musicFile = $repository->find($id);
        if (!$musicFile) {
            throw $this->createNotFoundException('Plik nie istnieje.');
        }


        $session->set('selected_music_file', $musicFile->getFileName());


        return $this->redirect('http://localhost:50929/dictation');
    }

}
