<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    public function index(): Response
    {
        return new Response('<h1>Hello world!</h1>');
    }

    public function helloName($name): Response
    {
        return new Response('<h1>Hello '. $name . '</h1>');
    }

    }

?>