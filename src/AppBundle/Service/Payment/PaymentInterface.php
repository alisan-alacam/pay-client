<?php

namespace AppBundle\Service\Payment;

interface PaymentInterface
{
    /**
     * Kur farkı düzenlemesi yapar
     * @return mixed
     */
    public function checkCurrency();

    /**
     * Ödemeyi gerçekleştirir
     * @return mixed
     */
    public function pay();

    /**
     * İlgili bölüme eposta gönderir
     * @return mixed
     */
    public function sendVoucher();
}