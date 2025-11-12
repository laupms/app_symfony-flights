<?php

namespace App\Form;

use App\Entity\Cities;
use App\Repository\CitiesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;


class CitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length([
                       'min' => 3,
                       'max' => 100,
                       'minMessage' => '❗️ Le nom de la ville doit avoir 3 caractères au minimum.',
                       'maxMessage' => '❗️ Le nom de la ville doit avoir 100 caractères au maximum.',
                    ]),
                    new NotBlank(),
                    new Type([
                        'type' => 'string',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ\s\-]+$/u',
                        'message' => '❗️ Le nom de la ville doit contenir uniquement des lettres, espaces ou tirets.',
                    ]),
                    ]

            ])

            ->add('country', TextType::class, [
                'label' => 'Pays',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length([
                       'min' => 3,
                       'max' => 100,
                       'minMessage' => '❗️ Le nom du pays doit avoir 3 caractères au minimum.',
                       'maxMessage' => '❗️ Le nom du pays doit avoir 100 caractères au maximum.',
                    ]),
                    new NotBlank(),
                    new Type([
                        'type' => 'string',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ\s\-]+$/u',
                        'message' => '❗️ Le nom du pays doit contenir uniquement des lettres, espaces ou tirets.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cities::class,
        ]);
    }
}
