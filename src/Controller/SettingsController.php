<?php

  namespace App\Controller;

  use App\Repository\SettingRepository;
  use Doctrine\ORM\EntityManagerInterface;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/settings/darkMode/post', name: 'app_settings_darkMode_updatePost', methods: 'post')]
    public function updateDarkMode(Request $request, SettingRepository $settingRepository, EntityManagerInterface $entityManager): Response {
      $darkMode = $settingRepository->findOneBy(["name" => "darkMode"]);
      if($request->request->get("darkMode") !== null && $request->request->get("darkMode") == 'true') {
        $darkMode->setValue(1);
      } else {
        $darkMode->setValue(0);
      }
      $entityManager->persist($darkMode);
      $entityManager->flush();

      $response = new Response(json_encode(["success" => true]));
      $response->headers->set('content-type', 'application/json');
      return $response;
    }
  }