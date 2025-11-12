<?php

namespace App\Form;

use App\Entity\Airline;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;

class AirlineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom de la compagnie aérienne',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Length([
                       'min' => 3,
                       'max' => 100,
                       'minMessage' => '❗️ Le nom de la compagnie doit avoir 3 caractères au minimum.',
                       'maxMessage' => '❗️ Le nom de la compagnie doit avoir 100 caractères au maximum.',
                    ]),
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9À-ÿ\s\-\.\']+$/u',
                        'message' => '❗️ Le nom de la compagnie ne peut contenir que des lettres, chiffres, espaces, tirets, points ou apostrophes.',
                    ]),
                ],
                
            ])
            ->add('logo', FileType::class, [
                'label' => 'Logo de la compagnie aérienne (format .webp / taille max. 50 ko)',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'accept' => '.webp',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '50k',
                        'mimeTypes' => ['image/webp'],
                        'mimeTypesMessage' => '❗️ Le logo doit être au format WEBP.',
                        'maxSizeMessage' => '❗️ Le logo ne doit pas dépasser 50ko.'
                    ]),
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Airline::class,
        ]);
    }
}
