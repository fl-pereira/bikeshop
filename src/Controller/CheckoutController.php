<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;

use App\Entity\Pedido;
use App\Repository\ProdutoRepository;


class CheckoutController extends AbstractController
{
	/**
	* @Route ("/checkout"), name="checkout"
	*/
	public function checkout(Request $request, ProdutoRepository $repo, SessionInterface $session, MailerInterface $mailer) : Response
	{
		$carrinho = $session->get('carrinho', []);
		$total = array_sum(array_map(function($produto) { return $produto->getPreco(); }, $carrinho));

		$pedido = new Pedido;

		$form = $this->createFormBuilder($pedido)
			->add('nome', TextType::class, [
				'label' => 'Nome completo'])
			->add('mail', TextType::class, [
				'label' => 'E-Mail'])
			->add('endereco', TextType::class, [
				'label' => 'Endereço / Cidade / Estado'
			])
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$pedido = $form->getData();

			foreach ($carrinho as $produto) {
				$pedido->getProdutos()->add($repo->find($produto->getId()));
			}

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($pedido);
			$entityManager->flush();

			$this->enviaEmailConfirmacao($pedido, $mailer);

			$session->set('carrinho', []);

			return $this->render('confirmacao.html.twig');
		}

		return $this->render('checkout.html.twig', [
			'total' => $total,
			'form' => $form->createView()
		]); 
	}

	private function enviaEmailConfirmacao(Pedido $pedido, MailerInterface $mailer)
	{
		$email = (new TemplatedEmail())
			->from('fpereira.media@gmail.com')
			->to(new Address($pedido->getMail(), $pedido->getNome()))
			->subject('Confirmação de Pedido')
			->htmlTemplate('emails/confirmacao.html.twig')
			->context(['pedido' => $pedido]);

		$mailer->send($email);
	}
}