<?php

namespace AppBundle\Factory;

use AppBundle\Service\Payment\Gateway\Paypal;
use AppBundle\Service\Payment\Gateway\Paytrek;
use AppBundle\Service\Payment\Gateway\Payu;

class PaymentGatewayFactory
{
    public static function create($paymentGatewaySlug, $em)
    {
        switch ($paymentGatewaySlug) {
            case 'paypal':
                $paymentGateway = new Paypal($em);
                break;

            case 'payu':
                $paymentGateway = new Payu($em);
                break;

            case 'paytrek':
                $paymentGateway = new Paytrek($em);
                break;

            default:
                $paymentGateway = null;
                break;
        }

        return $paymentGateway;
    }
}