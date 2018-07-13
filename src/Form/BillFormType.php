<?php

namespace App\Form;

use App\Entity\Abo;
use App\Entity\Customer;
use App\Entity\Bill;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class BillFormType extends AbstractType
{
    private $user;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->user = $options['data']['user'];

        $builder
            ->add('date', DateType::class, [
                'label' => 'Datum: ',
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
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->where('a.user = '.$this->user);
                },
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => null,
            'user' => null
        ]);
    }

    public function getBlockPrefix() {
        return 'app_bundle_bill_form_type';
    }
}
