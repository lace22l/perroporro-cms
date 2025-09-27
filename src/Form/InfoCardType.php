<?php

namespace App\Form;

use App\Entity\InfoCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextareaType::class, [])
            ->add('cardBody', TextareaType::class, [])
            ->add('colSize', IntegerType::class, [

            ])
            ->add('ordering')
            ->add('colOffset')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InfoCard::class,
        ]);
    }
}
