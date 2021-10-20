<?php

namespace App\Form;

use App\Entity\Particpant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Pseudo:',
                'required' => false,

            ])
            //->add('roles')
            ->add('password', RepeatedType::class, [

                'type' => PasswordType::class, 'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrter un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'invalid_message' => "mot de passe est invalide",
                'required' => false,
                //'option' => ['attr' => ['class' => 'password-field']],

                //'require' => true,

                'first_options' => ['label' => 'mot de passe:', 'attr' => ['class' => 'text-muted f-w-400 form-control'],],

                'second_options' => ['label' => 'Comfirmation:', 'attr' => ['class' => 'text-muted f-w-400 form-control'],],

            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Nom:',
                'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Prénom:',
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Téléphone:',
                'required' => false,
            ])
            ->add('mail', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Email:',
                'required' => false,
            ])
            //->add('administrateur')
            //->add('actif')
            //->add('sites_no_site')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Particpant::class,
        ]);
    }
}
