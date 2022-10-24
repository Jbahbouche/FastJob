<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Contrat;
use App\Entity\Domaine;
use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class, [
                'required'=>true,
                'label'=>"Titre de l'annonce",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('contrat', EntityType::class, [
                'class' => Contrat::class,
                'required'=>true,
                'label'=>"Type de contrat",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('domaine', EntityType::class, [
                'class' => Domaine::class,
                'required'=>true,
                'label'=>"Secteur d'activité",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('profil', TextareaType::class, [
                'required'=>true,
                'label'=>"Profil recherché",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('salaire', TextType::class, [
                'required'=>true,
                'label'=>"Salaire",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('departement', EntityType::class, [
                'class'=> Departement::class,
                'required'=>true,
                'label'=>"Departement:",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('ville', TextType::class, [
                'required'=>true,
                'label'=>"Ville",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
