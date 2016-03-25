<?php

namespace AppBundle\Form\Payment;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class PaymentType
 * @package AppBundle\Form
 */
class PaymentType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PaymentType constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'attr' => array('autofocus' => true),
                'label' => 'Name',
                'constraints' => array(
                    new NotBlank()
                ),
            ))
            ->add('gateway', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Payment Gateway',
                'choices'  => $this->em->getRepository('AppBundle:PaymentGateway')->getActivePaymentGatewayChoices(),
            ))
            ->add('value', null, array(
                'label' => 'value',
                'constraints' => array(
                    new NotBlank()
                ),
            ))
            ->add('currency', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'label' => 'Payment Gateway',
                'choices'  => array(
                    'usd' => 'USD',
                    'eur' => 'EUR',
                    'try' => 'TRY',
                ),
            ))
            ->add('pay', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
                'label' => 'Pay'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }
}