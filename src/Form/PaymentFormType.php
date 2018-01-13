<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Datum: ',
                'widget' => 'single_text'
            ])
            ->add('amount', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Betrag'
                ],
                'label' => false
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'placeholder' => 'Beschreibung'
                ],
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Payment::class
        ]);
    }

    public function getBlockPrefix() {
        return 'app_bundle_payment_form_type';
    }
}
