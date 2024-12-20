<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\RestaurantTable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'label' => 'Date',
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Date de la réservation'],
            ])
            ->add('guestCount', null, [
                'label' => 'Nombre de personnes',
                'attr' => ['placeholder' => 'Nombre de personnes'],
            ])
            ->add('table', EntityType::class, [
                'class' => RestaurantTable::class,
                'choice_label' => 'number',
                'label' => 'Table',
                'placeholder' => 'Sélectionnez une table',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
