<?php

  namespace App\Controller;

  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;

  class IndexController extends AbstractController {
    #[Route('/', name: 'app_index')]
    public function homepage(): Response {
      return $this->render('base.html.twig');
    }
  }