<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('adress')
            ->add('town')
            ->add('zipcode')
            ->add('email', EmailType::class)
            ->add('date_of_birth', DateType::class)

            ->add('langues', CollectionType::class, [
                'name',
                'level'
            ]) 

            ->add('licenses', CollectionType::class, [
                'name',
                'date_obtention', DateType::class,
            ])

            ->add('schools', CollectionType::class, [
                'name', 
                'start_date', DateType::class,

                'formations', CollectionType::class, [
                    'name',
                    'start_date',
                    'end_date',

                    'diplomes', CollectionType::class, [
                        'name',
                        'level',
                        'date_obtention', DateType::class,
                    ]
                ]
            ])

            ->add('companies', CollectionType::class, [
                'name',
                'start_date', DateType::class,
                'end_date', DateType::class,

                'activityArea', CollectionType::class, [
                    'name',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
            'allow_extra_fields' => true,
        ]);
    }
}
