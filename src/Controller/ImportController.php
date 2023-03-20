<?php

  namespace App\Controller;

  use App\Entity\Game;
  use App\Entity\System;
  use App\Repository\GameRepository;
  use App\Repository\SystemRepository;
  use Doctrine\ORM\EntityManagerInterface;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;
  use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
  use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
  use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
  use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
  use Symfony\Contracts\HttpClient\HttpClientInterface;

  class ImportController extends AbstractController {
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/import/search/results', name: 'app_search_results', methods: 'POST')]
    public function selectSearchResults(HttpClientInterface $client, Request $request): Response {
      $queryUrl = 'https://wss2.cex.uk.webuy.io/v3/boxes?q='. urlencode($request->request->get('searchQuery')) .'&sortBy=relevance&sortOrder=desc';
      $response = $client->request('GET', $queryUrl);
      $obj = json_decode($response->getContent(), false);
      $tmp_gaming_arr = array();
      if ($obj != null && isset($obj->response->data->boxes) && $obj->response->ack == "Success") {
        foreach($obj->response->data->boxes as $key => $value) {
          // Make sure you're returning only gaming software
          if($value->superCatId == 1) {
            $tmp_gaming_arr[] = [
              "boxId" => $value->boxId,
              "imgSrc" => $value->imageUrls->large,
              "name" => $value->boxName,
              "system" => $value->categoryFriendlyName
            ];
          }
        }
      } else {
        return $this->render("error.html.twig", ["errorMsg" => "No Results Found!"]);
      }
      return $this->render('searchResults.html.twig', [
        "results" => $tmp_gaming_arr
      ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/import/cexId', name: 'app_import_game_by_id', methods: 'POST')]
    public function importGameById(HttpClientInterface $client, Request $request, GameRepository $gameRepository, EntityManagerInterface $entityManager, SystemRepository $systemRepository): Response {
      $queryUrl = 'https://wss2.cex.uk.webuy.io/v3/boxes/'. urlencode($request->request->get('gameSelection')) .'/detail';
      $response = $client->request('GET', $queryUrl);
      $obj = json_decode($response->getContent(), false);
      $content = $obj->response->data->boxDetails[0];
      if ($content != null || $obj->response->ack == "Success") {
        $game = $gameRepository->findOneBy(["cexId" => $content->boxId]);
        if($game == null) {
          $game = new Game();
        }
        $game->setCexId($content->boxId)
             ->setBoxArtUri($content->imageUrls->large)
             ->setCurrentPrice($content->sellPrice)
             ->setName($content->boxName);
        $system = $systemRepository->findOneBy(["cexId" => $content->categoryId]);
        if($system == null) {
          $system = new System();
          $system->setName($content->categoryFriendlyName)->setCexId($content->categoryId);
        }
        $game->setSystem($system);
        $entityManager->persist($system);
        $entityManager->persist($game);
        $entityManager->flush();
      } else {
        return new Response("No Results Found!");
      }
      return $this->redirectToRoute('app_search');
    }

    #[Route('/import/search', name: 'app_search')]
    public function search(): Response {
      return $this->render('search.html.twig');
    }
  }