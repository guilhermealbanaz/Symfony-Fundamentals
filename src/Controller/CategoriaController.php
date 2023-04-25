<?php 
namespace App\Controller;

use App\Entity\Categoria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{
    #[Route("/categoria", name:"categoria_index")]
    public function index(EntityManagerInterface $em): Response
    {   
        //$em é um objeto que vai auxiliar a execução de ações no banco de dados
        $categoria = new Categoria();
        $categoria->setDescricaocategoria("Informática");
        $msg = "";
        try{
            $em->persist($categoria); // salvar a persistência em nivel de memória (não vai salvar efetivamente ainda)
            // para economizar hardware e custo, ele salva tarefas em niveis de memória e executa tudo ao mesmo tempo para 
            // não custar mais conexões.
            $em->flush(); //executa em definitivo no banco de dados
            $msg = 'Categoria cadastrada com sucesso!';
        }catch(Exception $e){
            $msg = 'Erro ao cadastrar categoria!';
        }
        return new Response("<h1>". $msg."</h1>" );
    }
}