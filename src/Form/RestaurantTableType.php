<?php

namespace App\Form;

use App\Entity\Restaurant;
use App\Entity\RestaurantTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', null, [
                'label' => 'Numéro',
                'attr' => ['placeholder' => 'Numéro de la table'],
            ])
            ->add('seats', null, [
                'label' => 'Places',
                'attr' => ['placeholder' => 'Nombre de places'],
            ])
            ->add('restaurant', EntityType::class, [
                'class' => Restaurant::class,
                'choice_label' => 'name',
                'label' => 'Restaurant',
                'placeholder' => 'Sélectionnez un restaurant',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RestaurantTable::class,
        ]);
    }
}
