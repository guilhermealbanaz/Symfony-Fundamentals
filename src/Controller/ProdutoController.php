<?php 

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProdutoController extends AbstractController
{
    #[Route("/produto", name:"produto_index")]
    public function index(EntityManagerInterface $em, CategoriaRepository $categoriaRepository):Response
    {
        $categoria = $categoriaRepository->find(1); // 1 é o id da categoria informática
        $produto = new Produto();
        $produto->setNomeproduto("Notebook");
        $produto->setValor(3000);
        $produto->setCategoria($categoria); 

        $msg = "";
        try{
            $em->persist($produto); // salvar a persistência em nivel de memória (não vai salvar efetivamente ainda)
            // para economizar hardware e custo, ele salva tarefas em niveis de memória e executa tudo ao mesmo tempo para 
            // não custar mais conexões.
            $em->flush(); //executa em definitivo no banco de dados
            $msg = 'Produto cadastrado com sucesso!';
        }catch(Exception $e){
            $msg = 'Erro ao cadastrar produto!';
        }
        return new Response("<h1>". $msg."</h1>" );
    }

    #[Route("/produto/adicionar", name:"produto_adicionar")]
    public function adicionar(): Response
    {
        $form = $this->createForm(ProdutoType::class);
        $data['titulo'] = "Adicionar novo produto";
        $data['form'] = $form;

        return $this->render('produto/form.html.twig', $data);
    }
}