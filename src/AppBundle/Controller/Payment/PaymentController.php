<?php

namespace AppBundle\Controller\Payment;

use AppBundle\AppBundle;
use AppBundle\Entity\PaymentGateway;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Payment\PaymentType;

class PaymentController extends Controller
{
    /**
     * @Route("payment", name="payment")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new PaymentType($this->getDoctrine()->getManager()));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $gatewaySlug = $form->get('gateway')->getData();

            $gatewayIsActive = $this->getDoctrine()
                ->getRepository('AppBundle:PaymentGateway')
                ->paymentGatewayIsActive($gatewaySlug)
            ;

            if ($gatewayIsActive === false) {
                $this->addFlash(
                    'notice',
                    'Ödeme yöntemi geçici olarak devre dışıdır.Lütfen tekrar deneyiniz.'
                );
                return $this->redirectToRoute('payment');
            }

            $gatewayService = $this->get('payment_gateway.factory');

            $gateway = $gatewayService::create($gatewaySlug, $this->getDoctrine()->getManager());

            $gateway->setGatewaySlug($gatewaySlug);
            $gateway->setValue($form->get('value')->getData());
            $gateway->setCurrency($form->get('currency')->getData());
            $gateway->setName($form->get('name')->getData());

            $payStatus = $gateway->pay();

            if ($payStatus->isSuccessful()) {
                $message = 'Ödeme başarıyla alındı';
            } else {
                $message = $payStatus->getMessage();
            }

            $this->addFlash(
                'notice',
                $message
            );
            return $this->redirectToRoute('payment');
        }

        return $this->render('payment/index.html.twig', array(
            'form' => $form->createView()
        ));
    }
}