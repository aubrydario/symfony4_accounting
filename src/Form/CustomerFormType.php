<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                'label' => 'Vorname'
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nachname'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => false
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Geburtstag',
                'widget' => 'single_text'
            ])
            ->add('telprivat', TextType::class, [
                'label' => 'Telefon Privat',
                'required' => false
            ])
            ->add('telmobile', TextType::class, [
                'label' => 'Telefon Mobile',
                'required' => false
            ])
            ->add('street', TextType::class, [
                'label' => 'Strasse'
            ])
            ->add('streetnr', TextType::class, [
                'label' => 'Strassennummer',
                'empty_data' => '',
                'required' => false
            ])
            ->add('city', TextType::class, [
                'label' => 'Ort'
            ])
            ->add('plz', NumberType::class, [
                'label' => 'PLZ'
            ])
            ->add('startdate', DateType::class, [
                'label' => 'Eintrittsdatum',
                'widget' => 'single_text'
            ])
            ->add('enddate', DateType::class, [
                'label' => 'Austrittsdatum',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('memo', TextareaType::class, [
                'label' => 'Memo',
                'required' => false
            ]);;
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
