<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Liga;
use App\Entity\Usuario;
use App\Form\EquipoType;
use App\Form\LoginType;

use Doctrine\ORM\EntityManagerInterface;
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
            'controller_name' => 'LoginController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profesor/eliminar_reserva", name="del_reserva")
     */
    public function delreserva(Request $request, EntityManagerInterface $em): Response
    {
        return $this->render('profesor/equipo.html.twig', [
            'controller_name' => 'LoginController'
        ]);
    }
}
