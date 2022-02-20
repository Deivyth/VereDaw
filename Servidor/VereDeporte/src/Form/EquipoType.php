<?php

namespace App\Form;

use App\Entity\Equipo;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add("nombre", TextType::class, array(
            "label" => " ",
            "attr" => ["class" => "col-12","placeholder"=> "Name"]
        ))
        ->add("photo", FileType::class, array(
            "attr" => ["class" => "mt-1"]
        ))
        ->add("capitan", EntityType::class, array(
            "class" => Usuario::class,
/*             "query_builder" => function(EntityRepository $er){
                return $er -> createQueryBuilder("u")
                    -> where("u.roles = :rol")
                    -> setParameter("rol", ["ROLE_JUGADOR"]);
            }, */
            "choice_label" => "nombre",
            "attr" => ["class" => "mt-1"]
        ))
        ->add("guardar", SubmitType::class, array(
            "label" => "Crear Equipo",
            "attr" => ["class" => "col-12 btn btn-primary mt-1"]));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipo::class,
        ]);
    }
}
