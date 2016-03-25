<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentGatewayRepository")
 * @ORM\Table(name="payment_gateways",
 *     indexes={
 *          @ORM\Index(name="slug", columns={"slug"}),
 *          @ORM\Index(name="createdAt", columns={"created_at"})
 *     }
 * )
 * Class PaymentGateway
 * @package AppBundle\Entity
 */
class PaymentGateway
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var
     */
    private $id;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     * @var
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     * @var
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     * @var
     */
    private $defaultExchangeRate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4)
     * @var
     */
    private $exchangeRateDifference;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

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
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getDefaultExchangeRate()
    {
        return $this->defaultExchangeRate;
    }

    /**
     * @param mixed $defaultExchangeRate
     */
    public function setDefaultExchangeRate($defaultExchangeRate)
    {
        $this->defaultExchangeRate = $defaultExchangeRate;
    }

    /**
     * @return mixed
     */
    public function getExchangeRateDifference()
    {
        return $this->exchangeRateDifference;
    }

    /**
     * @param mixed $exchangeRateDifference
     */
    public function setExchangeRateDifference($exchangeRateDifference)
    {
        $this->exchangeRateDifference = $exchangeRateDifference;
    }
}