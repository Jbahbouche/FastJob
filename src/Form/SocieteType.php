<?php

namespace App\Form;

use App\Entity\Societe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SocieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required'=>true,
                'label'=>"Nom de l'entreprise",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('representantNom', TextType::class, [
                'required'=>true,
                'label'=>"Votre nom",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('representantPrenom', TextType::class, [
                'required'=>true,
                'label'=>"Votre prénom",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('telephone', TextType::class, [
                'required'=>true,
                'label'=>"Téléphone (ne sera pas divulguer)",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('logo', FileType::class, [
                'required'=>false,
                'attr' => [
                    'class' =>'form-control my-2'
                ]
            ])
            ->add('adresse', TextType::class, [
                'required'=>true,
                'label'=>"Adresse/Siège social",
                'attr' => [
                    'class' =>'form-control my-2'
                ]
            ])
            ->add('site', TextType::class, [
                'required'=>true,
                'label'=>"Site web de l'entreprise",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required'=>true,
                'label'=>"Quelques mots pour décrire l'entreprise",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Societe::class,
        ]);
    }
}
