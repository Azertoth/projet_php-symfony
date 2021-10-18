<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Site;
use App\Entity\Sorties;
use App\Entity\Villes;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortirType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSortie', TextType::class, [

                "attr"  => [
                    "class"       => "form-control",
                    "placeholder" => "ex. sortie en plein air !",
                ]
            ])
            ->add('dateHeureDebut', DateType::class, [
                'label'    => 'Date et heure de la sortie',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle' => 'datetimepicker',
                    'data-target' => '#sortie_dateHeureDebut'
                ],
                'required'      => true,
                'mapped' => false
            ])
            ->add('duree', IntegerType::class, [
                "label" => "Durée: ",
                'attr' => [
                    'class' => 'form-control',
                    "form-group col-md-6"
                ]
            ])
            ->add('dateLimiteInscription', DateType::class, [
                "label" => "Date limite d'inscription: ",
                //  'html5'=>true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle' => 'datetimepicker',
                    'data-target' => '#sortie_dateLimiteInscription'
                ],
                'required'      => true,
                'mapped' => false
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                "label" => "Nombre de places: ",

                "attr"  => [
                    "class"       => "form-control"
                ]

            ])
            ->add('infosSortie', TextType::class, [
                "label" => "Description et info: ",
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('site', EntityType::class, [
                'class' => Site::class,
                "label" => "Site organisateur : ",
                'attr' => [
                    'class' => 'form-control'
                ],
                'choice_label' => function ($site) {
                    return $site->getNomSite();
                }
            ])
            ->add('lieux', EntityType::class, [
                'class' => Lieux::class,
                "label" => "Lieu : ",
                'attr' => [
                    'class' => 'form-control'
                ],
                'choice_label' => function ($lieu) {
                    return $lieu->getNomLieu();
                }
            ])
            // ->add('lieux', EntityType::class, [
            //     'class' => Lieux::class,
            //     "label" => "Ville : ",
            //     'attr' => [
            //         'class' => 'form-control'
            //     ],
            //     'choice_label' => function ($lieu) {
            //         return $lieu->getVille()->getNomVille();
            //     }
            // ])

            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-success w-100'
                ]
            ])
            ->add('publish', SubmitType::class, [
                'label' => 'Publier la sortie',
                'attr' => [
                    'class' => 'btn btn-success w-100'
                ]
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Annuler',
                'attr' => [
                    'class' => 'btn btn-success w-100'
                ]
            ])
            //            ->add('site',EntityType::class,[
            //                'class '=>Site::class,
            //                'choice_label' => 'nom_site',
            //                'query_builder' => function (EntityRepository $entityRepository) {
            //                    return $entityRepository->createQueryBuilder('s')->orderBy('s.nom_site', 'ASC');
            //                }
            //            ])
            //            ->add('Lieu',EntityType::class,[
            //                'class '=>Lieux::class,
            //                'choice_label' => 'nom_lieu',
            //                'query_builder' => function (EntityRepository $entityRepository) {
            //                    return $entityRepository->createQueryBuilder('l')->orderBy('l.nom_lieu', 'ASC');
            //                }
            //               ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
