<?php 


namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findBy([], ['priority' => 'ASC'], 3);
    
        return $this->render('home/index.html.twig', [
            'services' => $services,
        ]);
    }
}