<?php

namespace AppBundle\Service\Payment\Gateway;

use Doctrine\ORM\EntityManager;
use AppBundle\Service\Payment\Payment;

class Paypal extends Payment
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * Paypal constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        parent::__construct($entityManager);
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