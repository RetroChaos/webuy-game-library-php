<?php

  namespace App\Controller;

  use App\Repository\GameRepository;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;

  class CollectionController extends AbstractController {
    #[Route('/collection', name: 'app_collection_all')]
    public function showAll(GameRepository $gameRepository):Response {
      $collection = $gameRepository->findAll();
      return $this->render('collection.html.twig', [
        "collection" => $collection
      ]);
    }
  }