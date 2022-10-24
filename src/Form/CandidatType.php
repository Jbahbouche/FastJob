<?php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\Candidat;
use App\Entity\Competence;
use Doctrine\ORM\EntityRepository;
use App\Repository\CompetenceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('nom', TextType::class, [
                'required'=>true,
                'label'=>"Votre nom",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('prenom', TextType::class, [
                'required'=>true,
                'label'=>"Votre prénom",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('naissance', TextType::class, [
                'required'=>true,
                'label'=>"Votre date de naissance",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('telephone', TextType::class, [
                'required'=>true,
                'label'=>"Votre numéro de téléphone (ne sera pas communiquer)",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('domaine', EntityType::class, [
                'class' => Domaine::class,
                'required'=>true,
                'label'=>"Votre secteur d'activité",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('recherche', TextType::class, [
                'required'=>true,
                'label'=>"Le poste que vous recherchez",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('presentation', TextareaType::class, [
                'required'=>true,
                'label'=>"Quelques mots pour vous décrire",
                'attr'=>[
                    'class'=> 'form-control my-2'
                ]
            ])
            ->add('cvPDF',FileType::class, [
                'required'=>false,
                'label'=>"Votre CV au format PDF",
                'attr' => [
                    'class' =>'form-control my-2'
                ]
            ])
            ->add('competence', EntityType::class, [
                'class' => Competence::class,
                'expanded' =>true,
                'multiple' => true,
                'label' =>' ',
                'required' => false,
                'attr' => [
                    'class' =>'form-control my-2 d-flex justify-content-around flex-wrap'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
