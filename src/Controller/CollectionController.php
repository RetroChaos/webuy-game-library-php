<?php

  namespace App\Controller;

  use App\Entity\Game;
  use App\Repository\GameRepository;
  use App\Repository\SystemRepository;
  use Doctrine\ORM\EntityManagerInterface;
  use Doctrine\ORM\NonUniqueResultException;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request;
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
    public function showSingle(Game $game, SystemRepository $systemRepository): Response {
      $systems = $systemRepository->findAll();
      return $this->render('game.html.twig', [
          "game" => $game,
          "systems" => $systems
        ]);
    }
    #[Route('collection/{id}/edit/post', name: 'app_collection_editPost', methods:'POST')]
    public function editPost(Game $game, Request $request, EntityManagerInterface $entityManager): Response {
      $game->setName($request->request->get('name'))
           ->setAgeRating($request->request->get('ageRating'));
      $entityManager->persist($game);
      $entityManager->flush();

      $response = new Response(json_encode(["success" => true]));
      $response->headers->set('content-type', 'application/json');
      return $response;
    }

  }