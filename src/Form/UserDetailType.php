<?php

namespace App\Form;

use App\Entity\Participants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('nom', TextType::class)
            ->add('prenom')
            ->add('telephone')
            ->add('mail')
            // la fonction RepeatType permet de multiplier le meme champ
            ->add('motDePasse', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation']
                // ,PasswordType::class, [
                // // instead of being set onto the object directly,
                // // this is read and encoded in the controller
                // 'mapped' => false,
                // 'attr' => ['autocomplete' => 'new-password'],
                // 'constraints' => [
                //     new NotBlank([
                //         'message' => 'Merci d\'entrer un mot de passe',
                //     ]),
                //     new Length([
                //         'min' => 6,
                //         'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                //         // max length allowed by Symfony for security reasons
                //         'max' => 4096,
                //     ]),
                // ],
            ])
            // ->add('administrateur')
            // ->add('actif')
            // ->add('site')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
