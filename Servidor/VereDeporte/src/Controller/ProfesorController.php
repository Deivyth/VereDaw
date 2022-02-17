<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\LoginType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
                return $this->redirectToRoute("login");
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
    public function equipo(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $em): Response
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
                return $this->redirectToRoute("login");
            } else {
                return new Response("Contraseñas diferentes");
            }
        }

        return $this->render('login/register.html.twig', [
            'controller_name' => 'LoginController',
            "form" => $form->createView()
        ]);
    }
}
