<?php

namespace AppBundle\Service\Payment\Gateway;

use Doctrine\ORM\EntityManager;
use AppBundle\Service\Payment\Payment;
use AppBundle\Service\Payment\PaymentResponse;

class Payu extends Payment
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Paypal constructor.
     * @param EntityManager $entityManager
     * @param \Swift_Mailer $mailer
     */
    public function __construct(EntityManager $entityManager, \Swift_Mailer $mailer)
    {
        $this->em = $entityManager;
        parent::__construct($entityManager, $mailer);
    }

    /**
     * @return mixed
     */
    public function pay()
    {
        $this->checkCurrency();
        $data = array();

        $response = new PaymentResponse($data);

        // Başarılı ise mail gönder
        if ($response->isSuccessful()) {
            $this->sendVoucher();
        }
        return $response;
    }
}