<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $params = $this->getParams();

        $builder
            ->add('email', EmailType::class, $params['email'])
            ->add('username', TextType::class, $params['username'])
            ->add('plainPassword', RepeatedType::class, $params['plainPassword']);
    }

    public function getParams() : array
    {
        return [
            'email'         => [
                'label'       => 'Email',
                'required'    => true,
                'constraints' => [
                    new Email([
                        'message' => 'Email field should be a valid email address',
                    ]),
                ],
            ],
            'username'      => [
                'label'       => 'Name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your name',
                    ]),
                    new Length([
                        'min'        => 2,
                        'minMessage' => 'Name should be at least {{ limit }} characters',
                        'max'        => 20,
                    ]),
                ],
            ],
            'plainPassword' => [
                'type'            => PasswordType::class,
                'mapped'          => false,
                'first_options'   => ['label' => 'Password'],
                'second_options'  => ['label' => 'Repeat Password'],
                'invalid_message' => 'Password mismatch',
                'constraints'     => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min'        => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max'        => 4096,
                    ]),
                ],
            ],
        ];
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
