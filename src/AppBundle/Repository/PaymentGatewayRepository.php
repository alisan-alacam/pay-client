<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PaymentGatewayRepository extends EntityRepository
{
    public function getActivePaymentGatewayChoices()
    {
        $choices = array();
        $gateways = $this->getEntityManager()
            ->getRepository('AppBundle:PaymentGateway')
            ->findBy(array(
                'isActive' => 1
            ));

        foreach ($gateways as $gateway) {
            $choices[$gateway->getSlug()] = $gateway->getName();
        }

        return $choices;
    }
}