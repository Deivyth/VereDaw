<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Solicita;
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
        //$equipos = $em -> getRepository(Equipo::class) -> findAll();
        $solicita = new Solicita();

        $form = $this -> createFormBuilder($solicita)
        ->add("equipo",EntityType::class, array(
            "class" => Equipo::class,
            "choice_label" => "nombre",
            "label" => "Equipos "
        ))
        -> add("submit", SubmitType::class, array(
            "label" => "Solicitar equipo"
        ))
        -> getForm();
        
        $usuario = $this -> getUser();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $solicita -> setUsuario($usuario);
            try {
                $em->persist($solicita);
                $em->flush();
            } catch (\Exception $e) {
                return new Response("Esto no va");
            }
        }

        return $this->render('jugador/index.html.twig', [
            'controller_name' => 'JugadorController',
            "form" => $form-> createView()
            //'equipos' => $equipos
        ]);
    }
}
