<?php

namespace App\Form;

use App\Entity\Partido;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PuntosPartidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', EntityType::class, array(
                'mapped' => false, 
                "class" => Partido::class,
                "choice_label" => "id",
                "attr" => ["class" => "col-12 mb-1"]
            ))
            ->add('puntosLocal', NumberType::class, array(
                "attr" => ["class" => "col-12 mb-1"]
            ))
            ->add('puntosVisitante', NumberType::class, array(
                "attr" => ["class" => "col-12 mb-1"]
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Añadir',
                'attr' => ['class' => 'btn btn-primary col-12 mt-1'],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partido::class,
        ]);
    }
}
