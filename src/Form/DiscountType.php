<?php

namespace App\Form;

use App\Entity\Discount;
use App\Entity\Airline;

use App\Repository\AirlineRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Positive;

class DiscountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('airline', EntityType::class, [
                'class' => Airline::class,
                'choice_label' => 'name',
                'choice_label' => function ($airline) {
                    return sprintf('%s', 
                    $airline->getName(), 
                    );
                },
                'query_builder' => function (AirlineRepository $al) {
                    return $al->createQueryBuilder('a')
                    ->orderBy('a.name', 'ASC');
                },
                'label' => 'Compagnie aérienne',
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisir une compagnie',
                'constraints' => [
                    new NotBlank(),
                    ]
            ])

            ->add('value', NumberType::class, [
                'label' => 'Montant fixe de la réduction (en €)',
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'class' => 'form-control',
                    'step' => '0.01',
                    'min' => 0,
                    'placeholder' => 'ex: 10 pour 10€',
                ],
                'constraints' => [
                    new Positive([
                        'message' => '❗️ La réduction ne peut être négative.',
                    ]),
                    new NotBlank(),
                    ]
            ])
            
            ->add('date_start', DateType::class, [
                'widget' => 'choice',
                'label' => 'Date de début',
                'html5' => false, //désactive le format HTML5 anglais par défaut
                'format' => 'dd MMMM yyyy',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' =>'❗️ Le date de début doit être celle d\'aujourd\'hui ou supérieure à aujourd\'hui.',
                    ]),
                    new NotBlank(),
                ],
                'years' => [2025, 2026, 2027],
            ])

            ->add('date_end', DateType::class, [
                'widget' => 'choice',
                'label' => 'Date de fin',
                'html5' => false, //désactive le format HTML5 anglais par défaut
                'format' => 'dd MMMM yyyy',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
                'years' => [2025, 2026, 2027],
            
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Discount::class,
        ]);
    }
}
