<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Name',
                'attr' => array(
                    'placeholder' => 'your name'
                    )])
            ->add('email', EmailType::class, [
                'attr' => array(
                    'placeholder' => 'your email',
                    'oncopy' => "return false",
                    'onpaste' => "return false",
                    'oncut' => "return false"
                    )])
            ->add('password', PasswordType::class, [
                'attr' => array(
                    'placeholder' => 'your password'
                    )])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirm your password',
                'attr' => array(
                    'placeholder' => 'confirm your password'
                    )])
            ->add('Sign up', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
