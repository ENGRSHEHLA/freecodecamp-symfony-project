<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    #[Route("/", name: "app_main")]
    public function index()
    {
        return $this->render(view: 'home/index.html.twig');
    }
    #[Route("/custome/{name?}", name: "custome")]
    public function custome(Request $request)
    {
        $name = $request->get(key: 'name');
        return $this->render('home/custome.html.twig', [
            'name' => $name
        ]);
    }
}
