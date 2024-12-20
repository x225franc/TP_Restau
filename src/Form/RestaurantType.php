<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom du restaurant'],
            ])
            ->add('address', null, [
                'label' => 'Adresse',
                'attr' => ['placeholder' => 'Adresse du restaurant'],
            ])
            ->add('city', null, [
                'label' => 'Ville',
                'attr' => ['placeholder' => 'Ville du restaurant'],
            ])
            ->add('capacity', null, [
                'label' => 'Capacité',
                'attr' => ['placeholder' => 'Capacité du restaurant'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
