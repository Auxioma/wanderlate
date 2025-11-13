<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control ps-5',
                    'placeholder' => 'Your first name',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le prénom est obligatoire.',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.',
                        'max' => 50,
                        'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\-\'\s]+$/u',
                        'message' => 'Le prénom ne peut contenir que des lettres.',
                    ]),
                ],
            ])

            ->add('LastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control ps-5',
                    'placeholder' => 'Your last name',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le nom est obligatoire.',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                        'max' => 100,
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\-\'\s]+$/u',
                        'message' => 'Le nom ne peut contenir que des lettres.',
                    ]),
                ],
            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'autocomplete' => 'email',
                    'class' => 'form-control ps-5',
                    'placeholder' => 'Your email',
                ],
                'label' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L’email est obligatoire.',
                    ]),
                    new Assert\Email([
                        'message' => 'Veuillez entrer une adresse email valide.',
                        'mode' => 'strict', // renforce la validation
                    ]),
                    new Assert\Length([
                        'max' => 180,
                        'maxMessage' => 'L’email ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])


            ->add('phoneNumber', TelType::class, [
                'attr' => [
                    'class' => 'form-control js-phone-input',
                    'placeholder' => '01 02 03 04 05',
                    'autocomplete' => 'tel',
                ],
                'label' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le numéro de téléphone est obligatoire.',
                    ]),
                    new Assert\Regex([
                        // Format international E.164 ou formats classiques FR sans espaces obligatoires
                        'pattern' => '/^(\+?[0-9]{7,15})$/',
                        'message' => 'Veuillez entrer un numéro de téléphone valide.',
                    ]),
                    new Assert\Length([
                        'min' => 7,
                        'max' => 15,
                        'minMessage' => 'Le numéro est trop court.',
                        'maxMessage' => 'Le numéro est trop long.'
                    ]),
                ],
            ])
            

            ->add('birthDate', DateType::class, [
                'widget' => 'choice', // 3 champs : day / month / year
                'format' => 'dd-MM-yyyy',
                'label' => false,

                'years' => range(date('Y') - 120, date('Y')), // limite de 120 ans
                'months' => range(1, 12),
                'days' => range(1, 31),

                'attr' => [
                    'class' => 'form-control ps-5',
                ],

                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La date de naissance est obligatoire.',
                    ]),
                    new Assert\LessThan([
                        'value' => 'today',
                        'message' => 'La date de naissance doit être dans le passé.',
                    ]),
                ],
            ])

            ->add('country', CountryType::class, [
                'label' => false,
                'placeholder' => 'Select your country',
                'attr' => [
                    'class' => 'form-control ps-5',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le pays est obligatoire.',
                    ]),
                ],
            ])

            ->add('lang', LanguageType::class, [
                'label' => false,
                'placeholder' => 'Select your language',
                'attr' => [
                    'class' => 'form-control ps-5',
                ],
                'choice_filter' => function ($lang) {
                    // langues réellement supportées
                    $locales = ['fr', 'en']; 
                    return in_array($lang, $locales, true);
                },
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La langue est obligatoire.',
                    ]),
                ],
            ])

            ->add('currency', CurrencyType::class, [
                'label' => false,
                'placeholder' => 'Select your currency',
                'attr' => [
                    'class' => 'form-control ps-5',
                ],
                'choice_filter' => function ($currency) {
                    // Liste des monnaies supportées
                    $allowedCurrencies = ['USD', 'EUR', 'GBP', 'JPY', 'CHF', 'CAD'];
                    return in_array($currency, $allowedCurrencies, true);
                },
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La devise est obligatoire.',
                    ]),
                ],
            ])


            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('marketing', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'form-control ps-5 pe-5',
                        'placeholder' => 'Mot de passe (minimum 6 caractères)',
                    ],
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'form-control ps-5 pe-5',
                        'placeholder' => 'Confirmez le mot de passe',
                    ],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
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
