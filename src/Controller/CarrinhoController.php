<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CarrinhoController extends AbstractController
{
	/**
	* @Route ("/carrinho"), name="carrinho"
	*/
	public function carrinho(Request $request, SessionInterface $session) : Response
	{
		$carrinho = $session->get('carrinho', []);

		if ($request->isMethod('POST')){
			unset($carrinho[$request->request->get('id')]);
			$session->set('carrinho', $carrinho);
		}

		$total = array_sum(array_map(function($produto) { return $produto->getPreco(); }, $carrinho));

		return $this->render('carrinho.html.twig', [
			'carrinho' => $carrinho,
			'total' => $total
		]); 
	}
}