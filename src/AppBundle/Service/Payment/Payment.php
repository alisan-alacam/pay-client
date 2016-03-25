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
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Payment constructor.
     * @param EntityManager $entityManager
     * @param \Swift_Mailer $mailer
     */
    public function __construct(EntityManager $entityManager, \Swift_Mailer $mailer)
    {
        $this->em = $entityManager;
        $this->mailer = $mailer;
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
        $emailTemplate = $this->em
            ->getRepository('AppBundle:EmailTemplate')
            ->getEmailTemplateBySlug('payment_success_accounting');


        $dataMap = array(
            '[NAME]' => $this->getName(),
            '[VALUE]' => $this->getValue(),
            '[CURRENCY]' => $this->getCurrency(),
            '[CURRENT_DATE_TIME]' => (new \DateTime())->format('d.m.Y H:i:s')
        );

        $emailBody = str_replace(array_keys($dataMap), array_values($dataMap), $emailTemplate['content']);

        $message = \Swift_Message::newInstance()
            ->setSubject($emailTemplate['subject'])
            ->setFrom('help@testtest.com')
            ->setTo('accounting@testtest.com')
            ->setBody($emailBody, 'text/html')
        ;
        $this->mailer->send($message);
    }

    /**
     *
     */
    public function pay()
    {

    }
}