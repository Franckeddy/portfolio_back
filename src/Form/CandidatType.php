<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
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
            ->add('email')
            ->add('date_of_birth')
            ->add('langues')
            ->add('licenses')
            ->add('schools')
            ->add('companies')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
