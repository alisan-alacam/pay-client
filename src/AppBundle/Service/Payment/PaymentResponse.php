<?php

namespace AppBundle\Service\Payment;

class PaymentResponse
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var
     */
    private $data;

    /**
     * PaymentResponse constructor.
     * @param $data
     * @param int $statusCode
     */
    public function __construct($data, $statusCode = 200)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return empty($this->data['error']) && $this->getCode() < 400;
    }

    /**
     * @return null
     */
    public function getMessage()
    {
        if (isset($this->data['error_description'])) {
            return $this->data['error_description'];
        }
        if (isset($this->data['message'])) {
            return $this->data['message'];
        }

        return null;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->statusCode;
    }
}