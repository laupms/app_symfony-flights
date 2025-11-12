<?php

namespace App\Form;

use App\Entity\Airport;
use App\Entity\Cities;
use Dom\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Repository\CitiesRepository;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class AirportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'aéroport',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length([
                       'min' => 3,
                       'max' => 100,
                       'minMessage' => '❗️ Le nom de l\'aéroport doit avoir 3 caractères au minimum.',
                       'maxMessage' => '❗️ Le nom de l\'aéroport doit avoir 100 caractères au maximum.',
                    ]),
                    new NotBlank(),
                    ]
            ])
            ->add('code', TextType::class, [
                'label' => 'Code IATA de l\'aéroport (3 ou 4 lettres)',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length([
                       'min' => 3,
                       'max' => 4,
                       'minMessage' => '❗️ Le nom de l\'aéroport doit avoir 3 caractères au minimum.',
                       'maxMessage' => '❗️ Le nom de l\'aéroport doit avoir 4 caractères au maximum.',
                    ]),
                    new NotBlank(),
                    new Type([
                        'type' => 'string',
                        'message' => '❗️ Le code de l\'aéroport doit comporter uniquement des lettres.',
                    ])
                    ]
            ])
            ->add('city_id', EntityType::class, [
                'class' => Cities::class,
                'label' => 'Ville de l\'aéroport',
                'choice_label' => function ($cities) {
                    return sprintf('%s', 
                    $cities->getName(), 
                    );
                },
                'query_builder' => function (CitiesRepository $ct) {
                    return $ct->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');

                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisir une ville',
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Airport::class,
        ]);
    }
}
