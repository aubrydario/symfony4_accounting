<?php

namespace App\Form;

use App\Entity\Abo;
use App\Entity\Customer;
use App\Entity\Bill;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class EditBillFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Start Datum: ',
                'widget' => 'single_text'
            ])
            ->add('enddate', DateType::class, [
                'label' => 'End Datum: ',
                'widget' => 'single_text'
            ])
            ->add('customer', EntityType::class, [
                'label' => 'Kunde: ',
                'class' => Customer::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.active = 1');
                },
                'choice_label' => function (Customer $customer) {
                    return $customer->getFirstname().' '.$customer->getSurname();
                }
            ])
            ->add('abo', EntityType::class, [
                'label' => 'Abo: ',
                'class' => Abo::class,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Bill::class
        ]);
    }

    public function getBlockPrefix() {
        return 'app_bundle_edit_bill_form_type';
    }
}
