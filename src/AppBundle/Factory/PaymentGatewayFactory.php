<?php

namespace AppBundle\Factory;

use AppBundle\Service\Payment\Gateway\Paypal;
use AppBundle\Service\Payment\Gateway\Paytrek;
use AppBundle\Service\Payment\Gateway\Payu;

class PaymentGatewayFactory
{
    public static function create($paymentGatewaySlug, $em, \Swift_Mailer $mailer)
    {
        switch ($paymentGatewaySlug) {
            case 'paypal':
                $paymentGateway = new Paypal($em, $mailer);
                break;

            case 'payu':
                $paymentGateway = new Payu($em, $mailer);
                break;

            case 'paytrek':
                $paymentGateway = new Paytrek($em, $mailer);
                break;

            default:
                $paymentGateway = null;
                break;
        }

        return $paymentGateway;
    }
}