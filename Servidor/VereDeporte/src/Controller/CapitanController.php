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
        $solicitudes = $em -> getRepository(Solicita::class) -> findBy(["equipo" => $equipo]);
        
        if(isset($_POST["equipo"]) && isset($_POST["jugador"])){
            $equipo = $em -> getRepository(Equipo::class) -> findOneBy(["nombre" =>  $_POST["equipo"]]);
            $usuario = $em -> getRepository(Usuario::class) -> findOneBy(["nombre" => $_POST["jugador"]]);

            $usuario -> setEquipo($equipo);
            try {
                $em -> persist($usuario);
                $em -> flush();
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        if($_POST["jugador"]){
            $usuario = $em -> getRepository(Usuario::class) -> findOneBy(["nombre" => $_POST["jugador"]]);
        }
        
        return $this-> render('capitan/players.html.twig', [
            'controller_name' => 'CapitanController',
            "solicitudes" => $solicitudes
        ]);
    }

}
