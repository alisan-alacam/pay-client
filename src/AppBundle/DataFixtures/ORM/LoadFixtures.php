<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\EmailTemplate;
use AppBundle\Entity\PaymentGateway;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 *   $ php app/console doctrine:fixtures:load
 *
 * See http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 *
 */
class LoadFixtures implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadEmailTemplates($manager);
        $this->loadPaymentGateways($manager);
    }
    private function loadEmailTemplates(ObjectManager $manager)
    {
        $emailTemplate = new EmailTemplate();

        $emailTemplate->setName('Payment successful');
        $emailTemplate->setSlug('payment_success_accounting');
        $emailTemplate->setSubject('Payment successful');
        $emailTemplate->setContent($this->getEmailContent());

        $manager->persist($emailTemplate);
        $manager->flush();
    }

    private function getEmailContent()
    {
        return <<<MARKDOWN
            <p>A new payment is made. <br />Details are below: Name: [NAME] <br />Amount: [VALUE] [CURRENCY] <br />
            Time: [CURRENT_DATE_TIME]</p>
MARKDOWN;
    }

    private function loadPaymentGateways(ObjectManager $manager)
    {
        $paypalGateway = new PaymentGateway();

        $paypalGateway->setSlug('paypal');
        $paypalGateway->setName('Paypal');
        $paypalGateway->setIsActive(1);
        $paypalGateway->setDefaultExchangeRate('EUR');
        $paypalGateway->setExchangeRateDifference('1.0800');

        $manager->persist($paypalGateway);

        $payuGateway = new PaymentGateway();

        $payuGateway->setSlug('payu');
        $payuGateway->setName('payu');
        $payuGateway->setIsActive(0);
        $payuGateway->setDefaultExchangeRate('TRY');
        $payuGateway->setExchangeRateDifference('1.1200');

        $manager->persist($payuGateway);

        $paytrekGateway = new PaymentGateway();

        $paytrekGateway->setSlug('paytrek');
        $paytrekGateway->setName('Paytrek');
        $paytrekGateway->setIsActive(1);
        $paytrekGateway->setDefaultExchangeRate('USD');
        $paytrekGateway->setExchangeRateDifference('1.1000');

        $manager->persist($paytrekGateway);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}