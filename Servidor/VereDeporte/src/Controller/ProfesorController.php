<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Liga;
use App\Entity\Partido;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Form\EquipoType;
use App\Form\LoginType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Config\FosRest\ZoneConfig;

class ProfesorController extends AbstractController
{
    /**
     * @Route("/profesor", name="profesor")
     */
    public function index(): Response
    {
        return $this->render('profesor/index.html.twig', [
            'controller_name' => 'ProfesorController',
        ]);
    }

    /**
     * @Route("/profesor/registro", name="add_profesor")
     */
    public function registro(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $em): Response
    {
        $user = new Usuario();

        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get("password")->getData() == $form->get("password2")->getData()) {
                $user->setRoles(["ROLE_PROFESOR"]);

                $hashPassword = $passwordHasher->hashPassword(
                    $user,
                    $form->get("password")->getData()
                );
                $user->setPassword($hashPassword);

                try {
                    $em->persist($user);
                    $em->flush();
                } catch (\Exception $e) {
                    return new Response("Esto no va");
                }
                return $this->redirectToRoute("profesor");
            } else {
                return new Response("Contraseñas diferentes");
            }
        }

        return $this->render('login/register.html.twig', [
            'controller_name' => 'LoginController',
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/profesor/equipo", name="add_team")
     */
    public function equipo(Request $request, EntityManagerInterface $em): Response
    {
        $equipo = new Equipo();

        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form -> get("capitan") -> getData() -> setRoles(["ROLE_CAPITAN"]);
            $equipo -> setCapitan($form -> get("capitan") -> getData());

            try {
                $em->persist($equipo);
                $em->flush();
            } catch (\Exception $e) {
                return new Response("Esto no va");
            }
        }

        return $this->render('profesor/equipo.html.twig', [
            'controller_name' => 'LoginController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profesor/liga", name="add_liga")
     */
    public function liga(Request $request, EntityManagerInterface $em): Response
    {
        $liga = new Liga();
        $liga -> setFechaInicio(new \DateTime("tomorrow"));

        $form = $this -> createFormBuilder($liga)
        ->add("nombre", TextType::class, array(
            "label" => " ",
            "attr" => ["class" => "col-12","placeholder" => "Name"]
        ))
        ->add("fecha_inicio", DateType::class)
        ->add("guardar", SubmitType::class, array(
            "label" => "Crear Liga",
            "attr" => ["class" => "col-12 btn btn-primary mt-1"]))
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($liga);
                $em->flush();
            } catch (\Exception $e) {
                return new Response("Esto no va");
            }
        }

        return $this->render('profesor/equipo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profesor/ligas", name="list_ligas")
     */
    public function listLiga(EntityManagerInterface $em){
        $ligas = $em -> getRepository(Liga::class) -> findAll();

        return $this->render('profesor/listLiga.html.twig', [
            'ligas' => $ligas
        ]);
    }

    /**
     * @Route("profesor/reserva", name="list_all_reserva")
     */
    public function listAllReserva(EntityManagerInterface $em){
        $reservas = $em -> getRepository(Reserva::class) -> findAll();

        return $this->render('profesor/listReserva.html.twig', [
            'reservas' => $reservas
        ]);
    }

    /**
     * @Route("profesor/cambiarReserva", name="cambiar_reserva")
     */
    public function cambiarReserva(EntityManagerInterface $em,Request $request){

        $usuario = $this -> getUser();
        $reservas = $usuario -> getReservas();

        $form = $this -> createFormBuilder()
        ->add("id",EntityType::class, array(
            "class" => Reserva::class,
            "choice_label" => "id",
            "attr" => ["class" => "col-12"]
        ))
        ->add("nombre",EntityType::class, array(
            "class" => Usuario::class,
            "query_builder" => function(EntityRepository $er){
                return $er -> createQueryBuilder("u")
                    -> andWhere("JSON_CONTAINS(u.roles , :rol) = 1")
                    -> setParameter("rol", '"ROLE_PROFESOR"');
            },
            "choice_label" => "nombre",
            "attr" => ["class" => "col-12"]
        ))
        -> add("submit", SubmitType::class, array(
            "label" => "Cambiar vigilante",
            "attr" => ["class" => "btn btn-primary col-12 mt-1"]
        ))
        -> getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reserva = $form -> get("id") -> getData();
            $vigilante = $form -> get("nombre") -> getData();

            $reserva -> setVigilante($vigilante);

            try {
                $em->persist($reservas);
                $em->flush();
            } catch (\Exception $e) {
                return new Response("Esto no va:".$e);
            }
        }

        return $this->render('profesor/cambiarReserva.html.twig', [
            "reservas" => $reservas,
            "form" => $form -> createView()
        ]);
    }

    /**
     * @Route("profesor/cambiarPartido", name="cambiar_partido")
     */
    public function cambiarPartido(EntityManagerInterface $em, Request $request){

        $usuario = $this -> getUser();
        $partidos = $usuario -> getPartidos();

        $form = $this -> createFormBuilder()
        ->add("id",EntityType::class, array(
            "class" => Partido::class,
            "choice_label" => "id",
            "attr" => ["class" => "col-12"]
        ))
        ->add("nombre",EntityType::class, array(
            "class" => Usuario::class,
            "query_builder" => function(EntityRepository $er){
                return $er -> createQueryBuilder("u")
                    -> andWhere("JSON_CONTAINS(u.roles , :rol) = 1")
                    -> setParameter("rol", '"ROLE_PROFESOR"');
            },
            "choice_label" => "nombre",
            "attr" => ["class" => "col-12"]
        ))
        -> add("submit", SubmitType::class, array(
            "label" => "Cambiar vigilante",
            "attr" => ["class" => "btn btn-primary col-12 mt-1"]
        ))
        -> getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $partido = $form -> get("id") -> getData();
            $vigilante = $form -> get("nombre") -> getData();

            $partido -> setVigilante($vigilante);

            try {
                $em->persist($partido);
                $em->flush();
            } catch (\Exception $e) {
                return new Response("Esto no va:".$e);
            }
        }

        return $this->render('profesor/cambiarPartido.html.twig', [
            'partidos' => $partidos,
            "form" => $form -> createView()
        ]);
    }

    //AJAX
    public function addmatch(EntityManagerInterface $em){
        $liga = $em -> getRepository(Liga::class) -> find($_POST["id"]);

        $partido = new Partido();

    }

    /**
     * @Route("/profesor/eliminarReserva", name="delReserva")
     */
    public function delReserva(EntityManagerInterface $em){
        if(isset($_POST["id"])){

            $reserva = $em -> getRepository(Reserva::class) -> find($_POST["id"]);

            try {
                $em -> remove($reserva);
                $em -> flush();
            } catch (\Throwable $th) {
                return json_encode($th);
            }

            return $this-> redirect("/profesor/listarReserva");
        }
       
    }
}
