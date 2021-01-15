<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom',
                'placeholder' => 'Veuillez choisir',
                'attr' => ['class' => 'form-control'],
                'label' => 'La classe de l\'élève'
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer le nom de l\'élève',
                    'class' => 'form-control'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer le prénom de l\'élève',
                    'class' => 'form-control'
                ]
            ])
            ->add('dateDeNaissance', BirthdayType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('moyenne', TextType::class, [
                'attr' => [
                    'placeholder' => 'exemple : 12.5',
                    'class' => 'form-control'
                ]
            ])
            ->add('appreciation', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Votre appréciation',
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
