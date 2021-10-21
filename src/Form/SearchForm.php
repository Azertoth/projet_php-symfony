<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher par mot-clé'
                ]
            ])
            ->add('site', EntityType::class, [
                'label' => 'Site',
                'required' => false,
                'class' => Site::class,
                'choice_label' => 'nomSite'

            ])
            ->add('organiser', CheckboxType::class, [
                'label' => "J'organise",
                'required' => false,
            ])
            ->add('inscrit', CheckboxType::class, [
                'label' => "Je suis inscrit/e",
                'required' => false,
            ])
            ->add('pasInscrit', CheckboxType::class, [
                'label' => "Je ne suis pas encore inscrit/e",
                'required' => false,
            ])
            ->add('passee', CheckboxType::class, [
                'label' => "Sorties passées",
                'required' => false,
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Entre',
                'required' => false
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'label' => 'et',
                'required' => false
            ])
            //TODO AJOUTER  CHAMPS DATE

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function  getBlockPrefix()
    {
        return '';
    }
}
