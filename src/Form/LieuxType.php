<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomLieu', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Lieu:'
            ])
            ->add('rue', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Rue:'
            ])
            ->add('latitude', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Latitude:'
            ])
            ->add('longitude', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Longtitude:'
            ])
            ->add('ville', EntityType::class, [
                'class' => Villes::class,
                'choice_label' => function ($site) {
                    return $site->getNomVille();
                }
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-success w-10'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieux::class,
        ]);
    }
}
