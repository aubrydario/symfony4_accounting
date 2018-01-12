<?php

namespace App\Form;

use App\Entity\Abo;
use App\Entity\Customer;
use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Datum: ',
                'widget' => 'single_text'
            ])
            ->add('customer', EntityType::class, [
                'label' => 'Kunde: ',
                'class' => Customer::class,
                'choice_label' => 'firstname'
            ])
            ->add('abo', EntityType::class, [
                'label' => 'Abo: ',
                'class' => Abo::class,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Transaction::class
        ]);
    }

    public function getBlockPrefix() {
        return 'app_bundle_bill_form_type';
    }
}
