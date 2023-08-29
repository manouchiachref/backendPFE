<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('username')
            ->add('label')
            ->add('password')
            ->add('createdDate', DateTimeType::class, array(
                "html5" => false,
                "widget" => 'single_text',
                "format" => 'yyyy-MM-dd',
                "data" => new \DateTime(),
                "required" => false
            ))
            ->add('metier')
            ->add('zone')
            ->add('matricule_fiscal')
            ->add('solde')
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
