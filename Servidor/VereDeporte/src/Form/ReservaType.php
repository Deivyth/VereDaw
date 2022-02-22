<?php

namespace App\Form;

use App\Entity\Campo;
use App\Entity\Reserva;
use App\Entity\Usuario;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $years = array();
        $now = new DateTime("now");
        array_push($years, $now -> format("y"));
        array_push($years, $now -> format("y")+1);

        $builder
            ->add('vigilante',EntityType::class, array(
                "class" => Usuario::class,
                "query_builder" => function(EntityRepository $er){
                    return $er -> createQueryBuilder("u")
                        -> andWhere("JSON_CONTAINS(u.roles , :rol) = 1")
                        -> setParameter("rol", '"ROLE_PROFESOR"');
                },
                "choice_label" => "nombre",
                "attr" => ["class" => "mt-1 col-12"]
            ))
            ->add('campo', EntityType::class, array(
                "class" => Campo::class,
                "choice_label" => "tipo",
                "attr" => ["class" => "mt-1 col-12"]
            ))
            ->add('fecha', DateType::class, array(
                "attr" => ["class" => "mt-1 p-0 col-auto"],
                "years" => $years
            ))
            ->add("hora", TimeType::class, array(
                "mapped"=>false,
                "hours" => range(12,20),
                "minutes" => [0,30],
                "attr" => ["class" => "mt-1 col-6"]
            ))
            ->add("submit", SubmitType::class, array(
                "label" => "Crear",
                "attr" => ["class" => "col-12 btn btn-primary mt-1"]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reserva::class,
        ]);
    }
}
