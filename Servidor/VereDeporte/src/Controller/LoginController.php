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

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $au): Response
    {
        $lastError = $au -> getLastAuthenticationError();
        $lastUser = $au -> getLastUsername();

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'error' => $lastError,
            'last_username' => $lastUser
        ]);
    }

    /**
     * @Route("/", name="inicio")
     */
    public function inicio()
    {
        $user = $this-> getUser();

        if($user){
            $rol = $user -> getRoles()[0];

            switch($rol){
                case "ROLE_JUGADOR":
                    return $this->render('index/jugador.html.twig', [
                        'controller_name' => 'LoginController'
                    ]);
                    break;
                case "ROLE_CAPITAN":
                    return $this->render('index/jugador.html.twig', [
                        'controller_name' => 'LoginController'
                    ]);
                    break;
                case "ROLE_PROFESOR":
                    return $this->render('index/profesor.html.twig', [
                        'controller_name' => 'LoginController'
                    ]);
                    break;
            }
        }else{
            return $this->redirectToRoute("login");
        }
    }

    /**
     * @Route("/registro", name="registro")
     */
    public function registro(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $em): Response
    {
        $user = new Usuario();

        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get("password")->getData() == $form->get("password2")->getData()) {
                $user->setRoles(["ROLE_JUGADOR"]);

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
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout(): void
    {
        throw new \Exception(("NO no no"));
    }
}
