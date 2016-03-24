<?php

namespace AppBundle\Gateway;

interface PaymentInterface
{
    /**
     * @param $value
     * @param $currency
     * @return mixed
     */
    public function checkCurrency($value, $currency);

    /**
     * @param array $parameters
     * @return mixed
     */
    public function pay(array $parameters = array());

    /**
     * @param array $parameters
     * @return mixed
     */
    public function sendVoucher(array $parameters = array());
}