<?php

namespace App\Form;

use App\Entity\Abo;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AboFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name'
            ])
            ->add('price', NumberType::class, [
                'label' => 'Preis (Fr.)'
            ])
            ->add('maxVisits', NumberType::class, [
                'label' => 'Maximale Besuche'
            ])
            ->add('maxDays', NumberType::class, [
                'label' => 'Haltbar in Tagen'
            ])
            ->add('color', TextType::class, [
                'label' => 'Farbe',
                'attr' => [
                    'class' => 'colorpicker'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Abo::class
        ]);
    }

    public function getBlockPrefix() {
        return 'app_bundle_abo_form_type';
    }
}
