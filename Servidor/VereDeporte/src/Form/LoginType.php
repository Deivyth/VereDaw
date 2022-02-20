<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('nombre', TextType::class, array(
                "attr" => ["placeholder" => "Nombre", "class" => "col-12 m-1"]))
            ->add('email', EmailType::class,array(
                "attr" => ["placeholder" => "Email", "class" => "col-12 m-1"]))
            ->add('password', PasswordType::class,array(
                "attr" => ["placeholder" => "Password", "class" => "col-12 m-1"]))
            ->add("password2", PasswordType::class, array(
                "mapped"=>false, 
                "attr" => ["placeholder" => "Password", "class" => "col-12 m-1"]))
            ->add('photo', FileType::class, array(
                "attr" => ["class" => "col-12 m-1 text-primary"]
            ))
            ->add("submit", SubmitType::class,array(
                "attr" => ["class" => "btn btn-primary mt-1 col-12"]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
