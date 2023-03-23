<?php

  namespace App\Controller;

  use App\Entity\Game;
  use App\Repository\GameRepository;
  use Doctrine\ORM\NonUniqueResultException;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;

  class CollectionController extends AbstractController {
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/collection', name: 'app_collection_all')]
    public function showAll(GameRepository $gameRepository):Response {
      $collection = $gameRepository->findAll();
      $newest =  $gameRepository->findNewest();
      $totalCurrentPrice = $gameRepository->getTotalCurrentPrice();
      return $this->render('collection.html.twig', [
        "collection" => $collection,
        "newest" => $newest,
        "totalCurrentPrice" => $totalCurrentPrice['totalCurrentPrice']
      ]);
    }

    #[Route('collection/{id}', name: 'app_collection_single')]
    public function showSingle(Game $game): Response {
      return $this->render('game.html.twig', [
          "game" => $game
        ]);
    }
  }