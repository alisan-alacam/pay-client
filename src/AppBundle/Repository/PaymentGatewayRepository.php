<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class PaymentGatewayRepository
 * @package AppBundle\Repository
 */
class PaymentGatewayRepository extends EntityRepository
{
    /**
     * Aktif payment gateway i slug => value şeklinde döndürür
     * 
     * @return array
     */
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