<?php

namespace AppBundle\Controller\Payment;

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

        return $this->render('payment/index.html.twig', array(
            'form' => $form->createView()
        ));
    }
}