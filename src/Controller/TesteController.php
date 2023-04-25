<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TesteController extends AbstractController
{
    //  #[Route('/teste', name: 'teste')]
     public function index()
     {
         $data['titulo'] = 'Página de teste';
         $data['mensagem'] = 'Aprendendo templates no Symfony';
         $data['frutas'] = [
         [
            'nome' => 'banana',
            'valor' => 1.99
         ],
         [
           'nome' => 'laranja',
           'valor' => 2.99
         ]
        ];
         return $this->render('teste/index.html.twig', $data);
     }

    //  #[Route('/teste/menu/{id}')]
    public function helloName($name): Response
    {
        return new Response('<h1>Hello '. $name .'</h1>');
    }

    public function detalhes($id): Response
    {
        $data['titulo'] = 'Página de detalhes';
        $data['id'] = $id;
        return $this->render('teste/detalhes.html.twig', $data);
    }
} 

?>