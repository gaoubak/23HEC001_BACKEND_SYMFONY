<?php

namespace App\Form;

use App\Entity\Follower;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FollowerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username', // Replace with the actual property to display
            ])
            ->add('follower', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username', // Replace with the actual property to display
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Follower::class,
            'csrf_protection' => false,
        ]);
    }
}
