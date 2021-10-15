<?php

namespace App\Form;

use App\Entity\Particpant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Pseudo:',


            ])
            //->add('roles')
            ->add('password', RepeatedType::class, [

                'type' => PasswordType::class,
                'invalid_message' => "mot de pass invalid",
                //'option' => ['attr' => ['class' => 'password-field']],
                //'require' => true,
                'first_options' => ['label' => 'mot de passe:', 'attr' => ['class' => 'text-muted f-w-400 form-control'],],
                'second_options' => ['label' => 'Comfirmation:', 'attr' => ['class' => 'text-muted f-w-400 form-control'],],
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Nom:'
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Prénom:'
            ])
            ->add('telephone', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Téléphone:'
            ])
            ->add('mail', TextType::class, [
                'attr' => ['class' => 'text-muted f-w-400 form-control'],
                'label' => 'Email:'
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
