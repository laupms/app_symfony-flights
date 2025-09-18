<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'class' => 'form-control',
                ],

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'En cochant cette case, j\'accepte les termes de l\'inscription.',
                'constraints' => [
                    new IsTrue([
                        'message' => '❗️ Vous devez accepter les conditions pour continuer.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Mot de passe',
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => '❗️ Entrez votre mot de passe.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => '❗️ Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ]),
                    new Regex([
                        //minuscule : (?=.*[a-z]) / majuscule : (?=.*[A-Z]) / chiffre : (?=.*\d) / caractère spécial : (?=.*[\W_])
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                        'message' => '❗️ Votre mot de passe doit contenir au moins : une minuscule, une majuscule, un chiffre et un caractère spécial.',
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Rôle',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}