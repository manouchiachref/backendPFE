<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_projet')
            ->add('type')
            ->add('description')
            ->add('zone')
            ->add('prix')
            ->add('delais', DateTimeType::class, array(
                "html5" => false,
                "widget" => 'single_text',
                "format" => 'yyyy-MM-dd',
                "data" => new \DateTime(),
                "required" => false
            ))
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class
        ]);
    }
}
