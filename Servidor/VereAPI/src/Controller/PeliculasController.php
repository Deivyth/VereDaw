<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Peliculas;

/**
 * @Route("/peliculas/api")
 */
class PeliculasController extends AbstractFOSRestController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this -> em = $em;
    }

    /**
     * @Rest\Get ("/", name="lista_peliculas")
     * @Rest\View(serializerGroups= {"Peliculas"}, serializerEnableMaxDepthChecks=true)
     */
    public function lista_peliculas() 
    {
        return $this-> em -> getRepository(Peliculas::class)-> findAll();
    }

}
