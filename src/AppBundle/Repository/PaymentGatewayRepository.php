<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

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

    /**
     * Ödeme metodunun aktiflik durumunu döndürür
     *
     * @param $paymentGatewaySlug
     * @return bool
     */
    public function paymentGatewayIsActive($paymentGatewaySlug)
    {
        $qb = $this->createQueryBuilder('pg')
            ->select('pg.id')
            ->where('pg.isActive = 1')
            ->where('pg.slug = :slug')
            ->setParameters(array(
                'slug' => $paymentGatewaySlug
            ))
        ;

        try {
            $isActive = $qb->getQuery()->getOneOrNullResult();
        } catch (\Exception $e) {
            $isActive = null;
        }

        if ($isActive !== null) {
            $isActiveStatus = true;
        } else {
            $isActiveStatus = false;
        }
        return $isActiveStatus;
    }

    /**
     * Ödeme metodunun kur farkı ve kur adını döndürür
     *
     * @param $paymentGatewaySlug
     * @return mixed|null
     */
    public function getExchangeRateBySlug($paymentGatewaySlug)
    {
        $qb = $this->createQueryBuilder('pg')
            ->select('pg.defaultExchangeRate, pg.exchangeRateDifference')
            ->where('pg.isActive = 1')
            ->where('pg.slug = :slug')
            ->setParameters(array(
                'slug' => $paymentGatewaySlug
            ))
        ;
        try {
            $exchangeRate = $qb->getQuery()->getSingleResult(Query::HYDRATE_ARRAY);
        } catch (\Exception $e) {
            $exchangeRate = null;
        }
        return $exchangeRate;
    }
}