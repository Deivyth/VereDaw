<?php

namespace App\Controller;

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
    public function list_players(EntityManagerInterface $em): Response
    {
        $usuario = $em -> getRepository(Usuario::class) -> findOneBy(["email" => $this -> getUser() -> getUserIdentifier()]);
        
        $equipo = $usuario -> getEquipo();
        $solicitudes = $em -> getRepository(Solicita::class) -> findBy(["equipo" => $equipo]);
        return $this->render('capitan/players.html.twig', [
            'controller_name' => 'CapitanController',
            "solicitudes" => $solicitudes
        ]);
    }

    /**
     * @Route("/capitan/solicitudes/añadirequipo", name="list_players")
     */
    public function add_team_toUser(){

    }
}
