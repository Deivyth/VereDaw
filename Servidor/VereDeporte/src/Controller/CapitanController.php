<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Solicita;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CapitanController extends AbstractController
{
    /**
     * @Route("/capitan/solicitudes", name="list_players")
     */
    public function listPlayers(EntityManagerInterface $em): Response
    {
        $usuario = $em -> getRepository(Usuario::class) -> findOneBy(["email" => $this -> getUser() -> getUserIdentifier()]);
        
        $equipo = $usuario -> getEquipo();
        $solicitudes = $equipo -> getUsuarios();
        
        return $this-> render('capitan/players.html.twig', [
            'controller_name' => 'CapitanController',
            "solicitudes" => $solicitudes,
            "equipo" => $equipo
        ]);
    }

    //AJAX
    /**
     * @Route("/capitan/fichar", name="add_at_team")
     */
    public function addTeamAtUser(EntityManagerInterface $em): Response{
        if(isset($_POST["equipo"]) && isset($_POST["jugador"])){
            $usuario = $em -> getRepository(Usuario::class) -> find($_POST["jugador"]);
            $equipo = $em -> getRepository(Equipo::class) -> find($_POST["equipo"]);

            if($usuario -> getEquipo() == null){
                $usuario -> setEquipo($equipo);
                $usuario -> removeSolicitud($equipo);
                try {
                    $em -> persist($usuario);
                    $em -> flush();
                } catch (\Throwable $th) {
                    return new Response($th);
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

            $usuario = $em -> getRepository(Usuario::class) -> find($_POST["jugador"]);
            $equipo = $em -> getRepository(Equipo::class) -> find($_POST["equipo"]);
            
            $usuario -> removeSolicitud($equipo);
            try {
                $em -> persist($usuario);
                $em -> flush();
            } catch (\Throwable $th) {
                //throw $th;
            }

            return $this-> redirect("/capitan/solicitudes");
        }
    }
}
