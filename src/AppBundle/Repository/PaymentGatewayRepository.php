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
        $gateways = $this->createQueryBuilder('pg')
            ->select('pg.slug, pg.name')
            ->where('pg.isActive = 1')
            ->getQuery()
            ->getArrayResult();

        if (count($gateways) > 0) {
            foreach ($gateways as $gateway) {
                $choices[$gateway['slug']] = $gateway['name'];
            }
        }

        return $choices;
    }
}