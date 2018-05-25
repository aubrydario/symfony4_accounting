<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AttendanceFilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('from', DateType::class, [
                'label' => 'Von: ',
                'widget' => 'single_text'
            ])
            ->add('to', DateType::class, [
                'label' => 'Bis: ',
                'widget' => 'single_text'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Anwenden'
            ]);
    }

    public function getBlockPrefix() {
        return 'app_bundle_attendance_filter_form_type';
    }
}
