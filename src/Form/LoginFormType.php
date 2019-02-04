<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $params = $this->getParams();

        $builder
            ->add('email', EmailType::class, $params['email'])
            ->add('password', PasswordType::class, $params['password'])
            ->add('_remember_me', CheckboxType::class, $params['_remember_me']);
    }

    public function getParams() : array
    {
        return [
            'email'     => [
                'label'       => 'Email',
                'required'    => true,
                'constraints' => [
                    new Email([
                        'message' => 'Email field should be a valid email address',
                    ]),
                ],
            ],
            'password' => [
                'label' => 'Password',
            ],
            '_remember_me' => [
                'label'    => 'Remember me',
                'required' => false,
            ]
        ];
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class'      => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'csrf_token',
            'csrf_token_id'   => 'authenticate',
        ]);
    }
}
