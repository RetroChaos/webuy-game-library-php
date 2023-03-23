<?php

  namespace App\Controller;

  use App\Repository\GameRepository;
  use Doctrine\ORM\NonUniqueResultException;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;

  class DashboardController extends AbstractController {
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/', name: 'app_dashboard')]
    public function dashboard(GameRepository $gameRepository): Response {
      $newest =  $gameRepository->findNewest();
      $totalCurrentPrice = $gameRepository->getTotalCurrentPrice();
      $totalGames = $gameRepository->getTotalGames();
      return $this->render('dashboard.html.twig', [
        "newest" => $newest,
        "totalCurrentPrice" => $totalCurrentPrice['totalCurrentPrice'],
        "totalGames" => $totalGames['totalGames']
      ]);
    }
  }