<?php

  namespace App\Twig;

  use App\Repository\SettingRepository;
  use Symfony\Component\EventDispatcher\EventSubscriberInterface;
  use Symfony\Component\HttpKernel\KernelEvents;
  use Twig\Environment;

  class TwigGlobalSubscriber implements EventSubscriberInterface {

    private Environment $twig;
    private SettingRepository $repository;

    public function __construct(Environment $twig, SettingRepository $repository) {
      $this->twig    = $twig;
      $this->repository = $repository;
    }

    public function injectGlobalVariables() {
      $darkMode = $this->repository->findOneBy(["name" => "darkMode"]);
      $this->twig->addGlobal($darkMode->getName(), $darkMode->getValue());
    }

    public static function getSubscribedEvents(): array {
      return [ KernelEvents::CONTROLLER =>  'injectGlobalVariables' ];
    }
  }