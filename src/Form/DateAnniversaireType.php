<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use App\Entity\DateAnniversaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateAnniversaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('date', DateType::class, [
                'widget' => "single_text",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DateAnniversaire::class,
        ]);
    }
}
