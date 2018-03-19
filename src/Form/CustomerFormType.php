<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Herr' => 'Herr',
                    'Frau' => 'Frau'
                ],
                'label' => 'Anrede:',
                'expanded' => true,
                'multiple' => false
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Vorname'
                ],
                'label' => false
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nachname'
                ],
                'label' => false
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email'
                ],
                'label' => false
            ])
            ->add('telprivat', TextType::class, [
                'attr' => [
                    'placeholder' => 'Telefon Privat'
                ],
                'label' => false
            ])
            ->add('telmobile', TextType::class, [
                'attr' => [
                    'placeholder' => 'Telefon Mobile'
                ],
                'label' => false,
                'required' => false
            ])
            ->add('street', TextType::class, [
                'attr' => [
                    'placeholder' => 'Strasse'
                ],
                'label' => false
            ])
            ->add('streetnr', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Strassennummer'
                ],
                'label' => false
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ort'
                ],
                'label' => false
            ])
            ->add('plz', NumberType::class, [
                'attr' => [
                    'placeholder' => 'PLZ'
                ],
                'label' => false
            ])
            ->add('startdate', DateType::class, [
                'label' => 'Start Datum:',
                'widget' => 'single_text'
            ])
            ->add('enddate', DateType::class, [
                'label' => 'End Datum:',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('active', HiddenType::class, [
                'data' => 1
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Customer::class
        ]);
    }

    public function getBlockPrefix() {
        return 'app_bundle_customer_form_type';
    }
}
