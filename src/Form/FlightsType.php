<?php

namespace App\Form;

use App\Entity\Flights;
use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Tags;


use App\Repository\AirportRepository;
use App\Repository\AirlineRepository;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Positive;

class FlightsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num', TextType::class, [
                 'attr' => [
                    'readonly' => 'true',
                    'class' => 'form-control',
                ],
                 'label' => 'Numéro de vol',
                 'required' => 'false',
                 
            ])

            ->add('airline', EntityType::class, [
                'class' => Airline::class,
                'label' => 'Compagnie aérienne',
                'choice_label' => function ($airline) {
                    return sprintf('%s', 
                    $airline->getName(), 
                    );
                },
                'query_builder' => function (AirlineRepository $al) {
                    return $al->createQueryBuilder('a')
                    ->orderBy('a.name', 'ASC');

                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisir une compagnie',
                'constraints' => [
                    new NotBlank(),
                    ]
            ])

            ->add('departure', DateTimeType::class, [
                'label' => 'Départ',
                'html5' => false, //désactive le format HTML5 anglais par défaut
                'format' => 'dd MMMM yyyy',
                'attr' => [
                    'class' => 'form-control',
                ],
                'widget' => 'choice',

                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' =>'❗️ Le date doit être celle d\'aujourd\'hui ou supérieure à aujourd\'hui.',
                    ]),
                    new NotBlank(),
                ],
                'years' => [2025, 2026, 2027],
                ])

            ->add('airport_departure', EntityType::class, [
                'class' => Airport::class,
                'choice_label' => function ($airport) {
                    return sprintf('%s — %s (%s)', 
                    $airport->getCityId()->getCountry(),
                    $airport->getName(), 
                    $airport->getCityId()->getName(), 

                    );
                },
                'query_builder' => function (AirportRepository $ar) {
                    return $ar->createQueryBuilder('a')
                    ->join('a.city_id', 'c')
                    ->orderBy('c.country', 'ASC')
                    ->addOrderBy('c.name', 'ASC');
                },
                'label' => 'Aéroport de départ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisir un aéroport de départ',
                'constraints' => [
                    new NotBlank(),
                    new NotIdenticalTo([
                        'value' => 'airport_arrival',
                        'message' => '❗️ L\'aéroport de départ doit être différente de l\'aéroport d\'arrivé',
                    ]),
                    ]
            ])

            ->add('arrival', DateTimeType::class, [
                'label' => 'Arrivée',
                'attr' => [
                    'class' => 'form-control',
                ],
                'html5' => false, //désactive le format HTML5 anglais par défaut
                'format' => 'dd MMMM yyyy',
                'widget' => 'choice',
                'constraints' => [
                    new NotBlank(),
                ],
                'years' => [2025, 2026, 2027],
                ])

            ->add('airport_arrival', EntityType::class, [
                'class' => Airport::class,
                'choice_label' => function ($airport) {
                    return sprintf('%s — %s (%s)', 
                    $airport->getCityId()->getCountry(),
                    $airport->getName(), 
                    $airport->getCityId()->getName(), 
                    );
                },
                'query_builder' => function (AirportRepository $ar) {
                    return $ar->createQueryBuilder('a')
                    ->join('a.city_id', 'c')
                    ->orderBy('c.country', 'ASC')
                    ->addOrderBy('c.name', 'ASC');
                },
                'label' => 'Aéroport d\'arrivé',
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisir un aéroport d\'arrivé',
                'constraints' => [
                    new NotBlank(),
                    new NotIdenticalTo([
                        'value' => 'airport_departure',
                        'message' => '❗️ L\'aéroport d\'arrivé doit être différente de l\'aéroport de départ',
                    ]),
                    ]
            ])

            ->add('price', NumberType::class, [
                'label' => 'Prix du vol (en €)',
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => 0,
                ],
                'constraints' => [
                    new Positive([
                        'message' => '❗️ Le prix ne peut être négatif.',
                    ]),
                    new NotBlank(),
                    ]
                ])

            ->add('nb_seat', IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Positive([
                        'message' => '❗️ Le nombre de places ne peut être négatif.',
                    ]),
                    new NotBlank(),
                    new Type([
                        'type' => 'integer',
                        'message' => '❗️ Le nombre de places doit être obligatoirement un nombre.',
                    ])
                    ]
                ])
            
                ->add('tags', EntityType::class, [
                    'class' => Tags::class,
                    'choice_label' => 'name',
                    'label' => 'Tags',
                    'multiple' => true,
                    'expanded' => true, // case à cocher ou false si select multiple
                    'required' => false,
                    'by_reference' => false, // pour que addTag() soit appelé
                ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flights::class,
        ]);
    }
}
