<?php

namespace App\Controller;

use App\Entity\Campo;
use App\Entity\Equipo;
use App\Entity\Liga;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Form\ReservaType;
use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CapitanController extends AbstractController
{
    /**
     * @Route("/capitan/solicitudes", name="list_players")
     */
    public function listPlayers(): Response
    {
        $equipo = $this -> getUser() -> getEquipo();
        $solicitudes = $equipo -> getUsuarios();
        
        return $this-> render('capitan/players.html.twig', [
            "solicitudes" => $solicitudes,
            "equipo" => $equipo
        ]);
    }

    /**
     * @Route("/capitan/equipo", name="list_team")
     */
    public function listTeam(EntityManagerInterface $em): Response
    {
        $equipo = $this -> getUser() -> getEquipo() -> getId();
        $jugadores = $em -> getRepository(Usuario::class) -> findBy(["equipo" => $equipo]);
        
        return $this-> render('capitan/listTeam.html.twig', [
            "jugadores" => $jugadores
        ]);
    }

    /**
     * @Route("/capitan/reserva", name="add_reserva")
     */
    public function addReserva(EntityManagerInterface $em, Request $request){
        
        $error = "";
        $comprobacion = false;

        $reserva = new Reserva();
        $reserva -> setFecha(new \DateTime("today"));

        $form = $this -> createForm(ReservaType::class, $reserva);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){

            $fecha = $form -> get("fecha")-> getData();
            $hora = $form -> get("hora")-> getData();
            $campo = $form -> get("campo") -> getData();

            $dateTime = new DateTime($fecha -> format("d-m-Y")." ".$hora->format("H:i"));
            $tiempoPartido = new DateTime($dateTime -> format("d-m-Y")." ".$hora->format("H:i")." +90 min");

            $equipo = $this -> getUser() -> getEquipo();
            $reservas = $campo -> getReservas();
            
            foreach($reservas as $reservaBD){
                $fechaBD = $reservaBD -> getFecha();
                if(($fechaBD >= $dateTime)  && ($fechaBD <= $tiempoPartido)){
                    $comprobacion = false;
                    break;
                }else{
                    $comprobacion = true;
                }
            }

            $dia = $fecha -> format("D");
            //COMPROBACION DE ERRORES 
            if($fecha > new DateTime("now")){
                if($dia == "Sat" || $dia == "Sun"){
                    $error = "Solo se puede crear entre semana";
                }else{
                    if($comprobacion == true || sizeof($reservas) == 0){
                        $reserva -> setEquipo($equipo);
                        $reserva -> setFecha($dateTime);
                        try {
                            $em->persist($reserva);
                            $em->flush();
                        } catch (\Exception $e) {
                            $error = "Error con servidor";
                        }
                        $error = "Reserva creada";
                    }else{
                        $error = "Campo y fecha ya reservada";
                    }
                }
            }else{
                $error = "No se puede volver al pasado";
            }
        }

        return $this->render('capitan/reserva.html.twig', [
            "form" => $form->createView(),
            "error" => $error
        ]);
    }


    /**
     * @Route("/capitan/liga", name="add_liga_at_team")
     */
    public function addLiga(Request $request, EntityManagerInterface $em){
        $error = "";

        $form = $this -> createFormBuilder()
        ->add("apunta",EntityType::class, array(
            "class" => Liga::class,
            "choice_label" => "nombre",
            "label" => "Ligas "
        ))
        -> add("submit", SubmitType::class, array(
            "label" => "Solicitar liga",
            "attr" => ["class" => "btn btn-primary col-12 mt-1 mb-1"]
        ))
        -> getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipo = $this -> getUser() -> getEquipo();
            $liga = $form -> get("apunta") -> getData();
            $liga -> addApuntum($equipo);

            try {
                $em->persist($liga);
                $em->flush();
                $error = "Solicitud enviada";
            } catch (\Exception $e) {
                $error = "Error del servidor";
            }
        }

        return $this->render('capitan/liga.html.twig', [
            'error' => $error,
            "form" => $form-> createView()
        ]);
    }

    /**
     * @Route("/capitan/listarReserva", name="list_reserva")
     */
    public function listReserva(){
        $reservas = $this -> getUser() -> getEquipo() -> getReservas();

        return $this->render('capitan/listReserva.html.twig', [
            "reservas" => $reservas
        ]);
    }

    /**
     * @Route("/capitan/listarPartidos", name="list_partido")
     */

    public function listPartidos(EntityManagerInterface $em){
        $ligas = $this -> getUser() -> getEquipo() -> getLigas();
        $equipo = $this -> getUser() -> getEquipo() -> getId();


        return $this->render('capitan/listPartidos.html.twig', [
            "ligas" => $ligas,
            "equipo" => $equipo
        ]);
    }

    //AJAX
    /**
     * @Route("/capitan/fichar", name="add_at_team")
     */
    public function addTeamAtUser(EntityManagerInterface $em): Response{
        if(isset($_POST["equipo"]) && isset($_POST["jugador"])){
            $usuario = $em -> getRepository(Usuario::class) -> find($_POST["id"]);
            $equipo = $this -> getUser() -> getEquipo();

            if($usuario -> getEquipo() == null){
                $usuario -> setEquipo($equipo);
                $usuario -> removeSolicitud($equipo);
                try {
                    $em -> persist($usuario);
                    $em -> flush();
                } catch (\Exception $th) {
                    return new Response("Error con el servidor");
                }
            }else{
                return new Response("Este jugador ya esta fichado");
            }
        }

        return $this-> redirect("/capitan/solicitudes");
    }
    
    /**
     * @Route("/capitan/eliminar", name="del_at_request")
     */
    public function delAtRequest(EntityManagerInterface $em){
        if(isset($_POST["equipo"]) && isset($_POST["jugador"])){
            $usuario = $em -> getRepository(Usuario::class) -> find($_POST["id"]);
            $equipo = $this -> getUser() -> getEquipo();
            
            $usuario -> removeSolicitud($equipo);
            try {
                $em -> persist($usuario);
                $em -> flush();
            } catch (\Throwable $th) {
                return new Response("Error con el servidor");
            }
        }
        return $this-> redirect("/capitan/solicitudes");
    }

    /**
     * @Route("/capitan/eliminarReserva", name="del_reserva")
     */
    public function delReserva(EntityManagerInterface $em){
        if(isset($_POST["id"])){

            $reserva = $em -> getRepository(Reserva::class) -> find($_POST["id"]);

            try {
                $em -> remove($reserva);
                $em -> flush();
            } catch (\Throwable $th) {
                //return json_encode($th);
            }
        }
        return $this-> redirect("/capitan/solicitudes");
    }
}
