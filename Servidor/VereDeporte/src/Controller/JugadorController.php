<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Solicita;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JugadorController extends AbstractController
{
    /**
     * @Route("/jugador/solicitar_equipo", name="request_team")
     */
    public function request_team(Request $request,EntityManagerInterface $em): Response
    {   
        $error = "";
        $email = $this -> getUser() -> getUserIdentifier();
        $usuario = $em -> getRepository(Usuario::class) -> findOneBy(["email" => $email]);

        $form = $this -> createFormBuilder()
        ->add("solicitud",EntityType::class, array(
            "class" => Equipo::class,
            "choice_label" => "nombre",
            "label" => "Equipos ",
            "attr" => ["class" => "mb-1 mt-1 col-12"]
        ))
        -> add("submit", SubmitType::class, array(
            "label" => "Solicitar equipo",
            "attr" => ["class" => "btn btn-primary col-12 mb-1"]
        ))
        -> getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipo = $em -> getRepository(Equipo::class) -> find($form -> get("solicitud") -> getData() -> getId());
            $usuario -> addSolicitud($equipo);
            try {
                $em->persist($usuario);
                $em->flush();
                $error = "Solicitud enviada";
            } catch (\Exception $e) {
                return new Response("Esto no va:".$e);
            }
        }

        return $this->render('jugador/index.html.twig', [
            'error' => $error,
            "form" => $form-> createView()
        ]);

    }

    /**
     * @Route("/jugador/listarReserva", name="list_reservas")
     */
    public function listReserva(){

        $reservas = null;

        if($this -> getUser() -> getEquipo()){
            $reservas = $this -> getUser() -> getEquipo() -> getReservas();
        }

        return $this->render('jugador/listReserva.html.twig', [
            "reservas" => $reservas
        ]);
    }

    /**
     * @Route("/jugador/listarPartidos", name="list_partidos")
     */

    public function listPartidos(){
        $ligas = null;
        $equipo = null;

        if($ligas = $this -> getUser() -> getEquipo()){
            $ligas = $this -> getUser() -> getEquipo() -> getLigas();
            $equipo = $this -> getUser() -> getEquipo() -> getId();
        }
        

        return $this->render('jugador/listPartidos.html.twig', [
            "ligas" => $ligas,
            "equipo" => $equipo
        ]);
    }
}
