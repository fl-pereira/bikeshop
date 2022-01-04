<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProdutoRepository;

class ProdutoController extends AbstractController
{
    /**
     * @Route("/", name="produto")
     */
    public function index(ProdutoRepository $repo): Response
    {
        $bikes = $repo->findBy([]); 
        
        return $this->render('home.html.twig', [
            'bikes' => $bikes,
        ]);
    }

    /**
     * @Route("/produto/{id}")
     */
    public function detalhes ($id, Request $request, ProdutoRepository $repo, SessionInterface $session) : Response
    {
        $bike = $repo->find($id);

        if($bike === null){
            throw $this->createNotFoundException('Produto não existe.');
        }

        //adicionando ao carrinho
        $carrinho = $session->get('carrinho',[]);

        if ($request->isMethod('POST')) {
            $carrinho[$bike->getId()] = $bike;
            $session->set('carrinho', $carrinho);
        }

        $seNoCarrinho = array_key_exists($bike->getId(), $carrinho);

        return $this->render('detalhes.html.twig', [
            'bike' => $bike,
            'noCarrinho' => $seNoCarrinho,
            ]);
    }
}
