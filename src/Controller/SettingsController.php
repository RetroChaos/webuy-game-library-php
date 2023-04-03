<?php

  namespace App\Controller;

  use App\Repository\SettingRepository;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\HttpKernel\Kernel;
  use Symfony\Component\Routing\Annotation\Route;

  class SettingsController extends AbstractController {
    #[Route('/settings', name: 'app_settings')]
    public function allSettings(SettingRepository $settingRepository): Response {
      $info = array(
        ['name' => 'Application Version', 'value' => $_ENV['SOFTWARE_VERSION']],
        ['name' => 'Application Environment', 'value' => $_ENV['APP_ENV']],
        ['name' => 'Local IP Address', 'value' => getenv('SERVER_ADDR')],
        ['name' => 'Server OS', 'value' => php_uname()],
        ['name' => 'Database URL', 'value' => $_ENV['DATABASE_URL']],
        ['name' => 'PHP Version', 'value' => phpversion()],
        ['name' => 'Symfony Version', 'value' => Kernel::VERSION]
      );
      return $this->render('settings.html.twig', [
        'info' => $info,
        'generalSettings' => $settingRepository->findAll()
      ]);
    }
  }