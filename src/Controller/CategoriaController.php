<?php 
namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{
    #[Route("/categoria", name:"categoria_index")]
    #[IsGranted("ROLE_USER")]
    public function index(CategoriaRepository $categoriaRepository): Response
    {   
        //reestringir a pagina apenas aos ROLE_USER
        // $this->denyAccessUnlessGranted('ROLE_USER');
        $data['categorias'] = $categoriaRepository->findAll();
        $data['titulo'] = 'Gerenciar Categorias';

        return $this->render('categoria/index.html.twig', $data);
    }

    #[Route("/categoria/adicionar", name:"categoria_adicionar")]
    #[IsGranted("ROLE_USER")]
    public function adicionar(Request $request, EntityManagerInterface $em): Response // request-> contém as informações da requisição. em-> insere no banco de dados
    {
        $msg = '';
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //salvar a nova categoria no BD
            $em->persist($categoria);
            $em->flush();
            $msg = 'Categoria adicionada com sucesso!';
        }
        $data['titulo'] = 'Adicionar nova categoria';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->render('categoria/form.html.twig', $data);
    }

    #[Route("/categoria/editar/{id}", name:"categoria_editar")]
    #[IsGranted("ROLE_USER")]
    public function editar(EntityManagerInterface $em, $id, Request $request, CategoriaRepository $categoriaRepository): Response
    {
        $msg = '';
        $categoria = $categoriaRepository->find($id); // retorna a categoria pelo id
        $form = $this->createForm(CategoriaType::class, $categoria); // cria formulario 
        $form->handleRequest($request); // autocompleta cada campo

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $msg = 'Categoria atualizada com sucesso!';
        }

        $data['titulo'] = 'Editar Categoria'; 
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->render("categoria/form.html.twig", $data); // reaproveitando o mesmo componente para a edição da categoria
    }

    #[Route("/categoria/excluir/{id}", name:"categoria_excluir")]
    #[IsGranted("ROLE_USER")]
    public function excluir($id, EntityManagerInterface $em, CategoriaRepository $categoriaRepository):Response
    {
        if(isset($id)){
            $categoria = $categoriaRepository->find($id);  // procurar categoria pelo id
            $em->remove($categoria); //exclui a categoria do BD
            $em->flush(); //efetivamente excluir do bd
        }
        //redirecionar para index
        return $this->redirectToRoute('categoria_index');
        
    }

}