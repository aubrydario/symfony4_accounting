<?php

namespace App\Form;

use App\Entity\Hour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HourFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('day', ChoiceType::class, [
                'choices'  => [
                    'Montag' => 1,
                    'Dienstag' => 2,
                    'Mittwoch' => 3,
                    'Donnerstag' => 4,
                    'Freitag' => 5,
                    'Samstag' => 6,
                    'Sonntag' => 7
                ],
                'label' => 'Tag'
            ])
            ->add('time', TimeType::class, [
                'label' => 'Zeit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Hour::class
        ]);
    }

    public function getBlockPrefix() {
        return 'app_bundle_hour_form_type';
    }
}
