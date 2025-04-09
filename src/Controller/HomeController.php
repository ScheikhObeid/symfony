<?php 


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        $starshipCount = 458;
        return $this->render('home/home.html.twig', [
            'numberOfStarships' => $starshipCount,
        ]);
        // return new Response('<stron>Home</stron>');
    }
}