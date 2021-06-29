<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                'disabled' => true,
                'label' => 'Mon adresse email',
            ])
            ->add('firstname', TextType::class,[
                'disabled' => true
            ])
            ->add('lastname', TextType::class,[
                'disabled' => true
            ])
            ->add('old_password', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class,[
                'label' => 'Votre mot de passe actuel',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre mot de passe actuel'
                ],
                'constraints' => new Length([
                    'min' => 8,
                    'max' => 60
                ]),
                'mapped' => false
            ])
            ->add('new_password',RepeatedType::class,[
                'type'=> \Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
                'mapped' => false,
                'constraints' => new Length([
                    'min' => 8,
                    'max' => 60
                ]),
                'invalid_message' => 'Les mots de passes doivent etre indentiques !',
                'label' => 'Votre mot de passe',
                'required' => true,
                'first_options' => [
                    'label'=>'Votre nouveau de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre nouveau mot de passe'
                    ]
                ],
                'second_options' => [
                    'label'=>'Confirmez votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
                    ]
                ],
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Mettre à jour'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
