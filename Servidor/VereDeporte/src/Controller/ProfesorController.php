<?php

namespace App\Controller;

use App\Entity\Campo;
use App\Entity\Equipo;
use App\Entity\Liga;
use App\Entity\Partido;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Form\EquipoType;
use App\Form\LoginType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
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
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Config\FosRest\ZoneConfig;

class ProfesorController extends AbstractController
{

    /**
     * @Route("/profesor/registro", name="add_profesor")
     */
    public function registro(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $em): Response
    {
        $error = "";
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
                return $this->redirectToRoute("login");
            } else {
                $error = "Contraseña diferentes";
            }
        }

        return $this->render('login/register.html.twig', [
            "error" => $error,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/profesor/equipo", name="add_team")
     */
    public function equipo(Request $request, EntityManagerInterface $em): Response
    {
        $error = "";
        $equipo = new Equipo();

        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form -> get("capitan") -> getData() -> setRoles(["ROLE_CAPITAN"]);
            $form -> get("capitan") -> getData() -> setEquipo($equipo);
            $equipo -> setCapitan($form -> get("capitan") -> getData());

            try {
                $em->persist($equipo);
                $em->flush();
                $error = "Equipo creado con exito";
            } catch (\Exception $e) {
                $error = "Error del servidor";
            }
        }

        return $this->render('profesor/equipo.html.twig', [
            'error' => $error,
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

        return $this->render('profesor/liga.html.twig', [
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
    /**
     * @Route("/profesor/crearLiga", name="crearLiga")
     */
    public function addmatch(EntityManagerInterface $em){
        if(isset($_POST["id"])){
            $usuarios = $em -> getRepository(Usuario::class) -> findAll();
            $liga = $em -> getRepository(Liga::class) -> find($_POST["id"]);
            $campos = $em -> getRepository(Campo::class) -> findAll();
            $equipos = $liga -> getApunta();
            $numeroEquipos = sizeof($equipos)-1;
            $fecha = new DateTime("now");

            $profesores = [];
            foreach($usuarios as $usuario){
                if($usuario -> getRoles()[0] == "ROLE_PROFESOR"){
                    $profesores[] = $usuario;
                }
            }

/*             $fecha = $fecha -> modify("next Saturday");
            $partido = new Partido();

            $partido -> setLocal($equipos[0]);
            $partido -> setVisitante($equipos[sizeof($equipos)-1]);
            $partido -> setVigilante($profesores[rand(0,sizeof($profesores))]);
            $partido -> setFecha($fecha);
            $partido -> setCampo($campos[0]);

            try{
                $em -> persist($partido);
                $em -> flush();
            }catch(\Exception $e){
                return new Response($e);
            } */

            for($i = 0; $i < $numeroEquipos; $i++){
                $fecha = new DateTime($fecha -> modify("next Saturday"));
                $partido = new Partido();
    
                $partido -> setLocal($equipos[0]);
                $partido -> setVisitante($equipos[5]);
                $partido -> setVigilante($profesores[rand(0,sizeof($profesores)-1)]);
                $partido -> setFecha($fecha);
                $partido -> setCampo($campos[0]);
                $partido -> setLiga($liga);
    
                try{
                    $em -> persist($partido);
                    $em -> flush();
                }catch(\Exception $e){
                    return new Response($e);
                }
                /* for($e = $numeroEquipos; $e >= 0; $e--){
                    if($equipos[$i] -> getId() != $equipos[$e] -> getId()){
                        $fecha = $fecha -> modify("next Saturday");
                        $partido = new Partido();

                        $partido -> setLocal($equipos[$i]);
                        $partido -> setVisitante($equipos[$e]);
                        $partido -> setVigilante($profesores[rand(0,sizeof($profesores))]);
                        $partido -> setFecha($fecha);
                        $partido -> setCampo($campos[0]);

                        try{
                            $em -> persist($partido);
                            $em -> flush();
                        }catch(\Exception $e){
                            return new Response($e);
                        }
                    }
                } */
            }
        }

        return $this -> redirect("/profesor/ligas");
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
