<?php

namespace AppBundle\Service\Payment;

use Doctrine\ORM\EntityManager;

class Payment implements PaymentInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Payment constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $value;

    /**
     * @var
     */
    private $currency;

    /**
     * @var
     */
    private $gatewaySlug;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getGatewaySlug()
    {
        return $this->gatewaySlug;
    }

    /**
     * @param mixed $gatewaySlug
     */
    public function setGatewaySlug($gatewaySlug)
    {
        $this->gatewaySlug = $gatewaySlug;
    }

    /**
     * @return mixed
     */
    public function checkCurrency()
    {
        $exchangeRate = $this->em
            ->getRepository('AppBundle:PaymentGateway')
            ->getExchangeRateBySlug($this->getGatewaySlug())
        ;

        if ($exchangeRate['defaultExchangeRate'] != $this->getCurrency()) {
            $newValue = $exchangeRate['exchangeRateDifference'] * $this->getValue();
            $this->setValue($newValue);
        }
    }

    /**
     * @return mixed
     */
    public function sendVoucher()
    {
        // TODO: Implement sendVoucher() method.
    }

    /**
     *
     */
    public function pay()
    {

    }
}