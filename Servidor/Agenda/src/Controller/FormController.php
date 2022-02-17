<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Tarea;
use App\Entity\Categoria;
use App\Form\TareaType;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    public function index(): Response
    {
        $tarea = new Tarea();
        $tarea -> setNombre("Hacer ejercicio de PHP");
        $tarea -> setFecha(new \DateTime("tomorrow"));

        $form = $this -> createFormBuilder($tarea)
        ->add("nombre", TextType::class)
        ->add("fecha", DateTimeType::class)
        ->add("categoria", EntityType::class, array(
            "class" => Categoria::class,
            "choice_label" => "nombre",
        ))
        ->add("guardar", SubmitType::class, array("label" => "Crear Tarea"))
        ->getForm();

        return $this->render('form/form.html.twig', [
            'controller_name' => 'FormController',
            "form" => $form -> createView()
        ]);
    }

    /**
     * @Route("/contacto/nuevo", name="nuevo_contacto")
     */
    public function nuevo(Request $request){ 
        $contacto = new Contacto(); 
        $formulario = $this->createFormBuilder($contacto) 
        ->add("nombre", TextType::class)
        ->add("fecha", DateTimeType::class)
        ->add("guardar", SubmitType::class, array("label" => "Crear Tarea"))
        ->getForm();
        
        $formulario->handleRequest($request); 
        if ($formulario->isSubmitted() && $formulario->isValid()) { 
            $contacto = $formulario->getData(); 
            $entityManager = $this->getDoctrine()->getManager(); 
            $entityManager->persist($contacto); 
            $entityManager->flush(); 
            return $this->redirectToRoute('inicio'); 
        } 
        return$this->render('nuevo.html.twig', array( 'formulario' => $formulario->createView()));
    }

    /**
     * @Route("/formCreate", name="app_form")
     */
    public function index2(): Response
    {
        $tarea = new Tarea();
        $tarea -> setNombre("Hacer ejercicio de PHP");
        $tarea -> setFecha(new \DateTime("tomorrow"));

        $form = $this -> createForm(TareaType::class, $tarea);

        return $this->render('form/form.html.twig', [
            'controller_name' => 'FormController',
            "form" => $form -> createView()
        ]);
    }

}