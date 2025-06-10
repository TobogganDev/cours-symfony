<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->redirectToRoute('app_login');
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(ArticleRepository $articleRepository): Response
    {
        $user = $this->getUser();

        // Si admin, voir tous les articles, sinon voir seulement les siens
        if ($this->isGranted('ROLE_ADMIN')) {
            $articles = $articleRepository->findAll();
        } else {
            $articles = $articleRepository->findBy(['user' => $user]);
        }

        return $this->render('home/dashboard.html.twig', [
            'articles' => $articles,
        ]);
    }
}
