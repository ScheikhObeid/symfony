<?php 


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        $starshipCount = 457;
        return $this->render('main/template.html.twig', [
            'numberOfStarships' => $starshipCount,
        ]);
        // return new Response('<stron>Home</stron>');
    }
}