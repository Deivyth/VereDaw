<?php

namespace App\Controller;

use App\Entity\Campo;
use App\Entity\Equipo;
use App\Entity\Liga;
use App\Entity\Partido;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Form\EquipoType;
use App\Form\LoginType;
use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
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
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Config\FosRest\ZoneConfig;

class ProfesorController extends AbstractController
{
    /**
     * @Route("/profesor/registro", name="add_profesor")
     */
    public function registro(
        UserPasswordHasherInterface $passwordHasher,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $error = '';
        $user = new Usuario();

        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (
                $form->get('password')->getData() ==
                $form->get('password2')->getData()
            ) {
                $user->setRoles(['ROLE_PROFESOR']);

                $hashPassword = $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                );
                $user->setPassword($hashPassword);

                try {
                    $em->persist($user);
                    $em->flush();
                } catch (\Exception $e) {
                    return new Response('Esto no va');
                }
                return $this->redirect('/');
            } else {
                $error = 'Contraseña diferentes';
            }
        }

        return $this->render('login/register.html.twig', [
            'error' => $error,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profesor/equipo", name="add_team")
     */
    public function equipo(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $error = '';
        $equipo = new Equipo();

        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form
                ->get('capitan')
                ->getData()
                ->setRoles(['ROLE_CAPITAN']);
            $form
                ->get('capitan')
                ->getData()
                ->setEquipo($equipo);
            $equipo->setCapitan($form->get('capitan')->getData());

            try {
                $em->persist($equipo);
                $em->flush();
                $error = 'Equipo creado con exito';
            } catch (\Exception $e) {
                $error = 'Error del servidor';
            }
        }

        return $this->render('profesor/equipo.html.twig', [
            'error' => $error,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profesor/liga", name="add_liga")
     */
    public function liga(Request $request, EntityManagerInterface $em): Response
    {
        $liga = new Liga();
        $liga->setFechaInicio(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($liga)
            ->add('nombre', TextType::class, [
                'label' => ' ',
                'attr' => ['class' => 'col-12', 'placeholder' => 'Name'],
            ])
            ->add('fecha_inicio', DateType::class)
            ->add('guardar', SubmitType::class, [
                'label' => 'Crear Liga',
                'attr' => ['class' => 'col-12 btn btn-primary mt-1'],
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($liga);
                $em->flush();
            } catch (\Exception $e) {
                return new Response('Esto no va');
            }
        }

        return $this->render('profesor/liga.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profesor/ligas", name="list_ligas")
     */
    public function listLiga(EntityManagerInterface $em)
    {
        $ligas = $em->getRepository(Liga::class)->findAll();

        return $this->render('profesor/listLiga.html.twig', [
            'ligas' => $ligas,
        ]);
    }

    /**
     * @Route("profesor/reserva", name="list_all_reserva")
     */
    public function listAllReserva(EntityManagerInterface $em)
    {
        $reservas = $em->getRepository(Reserva::class)->findAll();

        return $this->render('profesor/listReserva.html.twig', [
            'reservas' => $reservas,
        ]);
    }

    /**
     * @Route("profesor/cambiarReserva", name="cambiar_reserva")
     */
    public function cambiarReserva(EntityManagerInterface $em, Request $request)
    {
        $error = "";
        $usuario = $this-> getUser();
        $reservas = $usuario-> getReservas();

        $form = $this->createFormBuilder()
            ->add('id', EntityType::class, [
                'class' => Reserva::class,
                'query_builder' => function (EntityRepository $er) {
                    $id = $this -> getUser() -> getId();

                    return $er
                        ->createQueryBuilder('u')
                        ->where('u.vigilante = :vigilante')
                        ->setParameter('vigilante', $id);
                },
                'choice_label' => 'id',
                'attr' => ['class' => 'col-12'],
            ])
            ->add('nombre', EntityType::class, [
                'class' => Usuario::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('u')
                        ->andWhere('JSON_CONTAINS(u.roles , :rol) = 1')
                        ->setParameter('rol', '"ROLE_PROFESOR"');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'col-12'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Cambiar vigilante',
                'attr' => ['class' => 'btn btn-primary col-12 mt-1'],
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reserva = $form-> get('id')->getData();
            $vigilante = $form-> get('nombre')->getData();

            $reserva->setVigilante($vigilante);

            try {
                $em->persist($reserva);
                $em->flush();
            } catch (\Exception $e) {
                $error = "Error con el servidor";
            }
        }

        return $this->render('profesor/cambiarReserva.html.twig', [
            'reservas' => $reservas,
            "error" => $error,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("profesor/cambiarPartido", name="cambiar_partido")
     */
    public function cambiarPartido(EntityManagerInterface $em, Request $request, Security $security)
    {
        $usuario = $this-> getUser();
        $partidos = $usuario-> getPartidos();

        $form = $this->createFormBuilder()
            ->add('id', EntityType::class, [
                'class' => Partido::class,
                'query_builder' => function (EntityRepository $er) {
                    $id = $this -> getUser() -> getId();

                    return $er
                        ->createQueryBuilder('u')
                        ->where('u.vigilante = :vigilante')
                        ->setParameter('vigilante', $id);
                },
                'choice_label' => 'id',
                'attr' => ['class' => 'col-12'],
            ])
            ->add('nombre', EntityType::class, [
                'class' => Usuario::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('u')
                        ->andWhere('JSON_CONTAINS(u.roles , :rol) = 1')
                        ->setParameter('rol', '"ROLE_PROFESOR"');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'col-12'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Cambiar vigilante',
                'attr' => ['class' => 'btn btn-primary col-12 mt-1'],
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $partido = $form->get('id')->getData();
            $vigilante = $form->get('nombre')->getData();

            $partido->setVigilante($vigilante);

            try {
                $em->persist($partido);
                $em->flush();
            } catch (\Exception $e) {
                return new Response('Esto no va:' . $e);
            }
        }

        return $this->render('profesor/cambiarPartido.html.twig', [
            'partidos' => $partidos,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("profesor/addScore", name="add_score")
     */
    public function addScore(EntityManagerInterface $em, Request $request, Security $security)
    {
        $usuario = $this-> getUser();
        $partidos = $usuario-> getPartidos();

        $form = $this->createFormBuilder()
            ->add('id', EntityType::class, [
                'class' => Partido::class,
                'query_builder' => function (EntityRepository $er) {
                    $id = $this -> getUser() -> getId();

                    return $er
                        ->createQueryBuilder('u')
                        ->where('u.vigilante = :vigilante')
                        ->setParameter('vigilante', $id);
                },
                'choice_label' => 'id',
                'attr' => ['class' => 'col-12'],
            ])
            ->add('nombre', EntityType::class, [
                'class' => Usuario::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('u')
                        ->andWhere('JSON_CONTAINS(u.roles , :rol) = 1')
                        ->setParameter('rol', '"ROLE_PROFESOR"');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'col-12'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Cambiar vigilante',
                'attr' => ['class' => 'btn btn-primary col-12 mt-1'],
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $partido = $form->get('id')->getData();
            $vigilante = $form->get('nombre')->getData();

            $partido->setVigilante($vigilante);

            try {
                $em->persist($partido);
                $em->flush();
            } catch (\Exception $e) {
                return new Response('Esto no va:' . $e);
            }
        }

        return $this->render('profesor/cambiarPartido.html.twig', [
            'partidos' => $partidos,
            'form' => $form->createView(),
        ]);
    }

    //AJAX
    /**
     * @Route("/profesor/crearLiga", name="crearLiga")
     */
    public function addmatch(EntityManagerInterface $em)
    {
        if (isset($_POST['id'])) {
            $usuarios = $em->getRepository(Usuario::class)->findAll();
            $profesores = [];
            foreach ($usuarios as $usuario) {
                if ($usuario->getRoles()[0] == 'ROLE_PROFESOR') {
                    $profesores[] = $usuario;
                }
            }

            $liga = $em->getRepository(Liga::class)->find($_POST['id']);
            $campos = $em->getRepository(Campo::class)->findAll();
            $equipos = $liga-> getApunta();

            $participantes = sizeof($equipos);
            $z = 0;
            $y = $participantes - 2;

            $partidos = $participantes * ($participantes-1) / 2;
            $rondas = $participantes - 1;
            $vs = $participantes/2;

            $dia = 0;
            $fecha = new DateTime("next Saturday +15 hour");
            $intervalo = new DateInterval("P7D");
            $fechas = new DatePeriod($fecha, $intervalo, $partidos);
            $arrayFechas = [];
            foreach($fechas as $fecha){
                $arrayFechas[] = $fecha;
            }

            for($i = 0; $i < $rondas; $i++){
                for($e = 0; $e < $vs; $e++){
                    if($e != 0){
                        if($y == -1){
                            $y =  $participantes - 2;
                        }
                        if($z == $participantes - 1){
                            $z = 0;    
                        }
                        $this -> creatematch($equipos[$z],$equipos[$y],$arrayFechas[$dia],$profesores,$campos[0],$liga, $em);
                        $y--;
                    }else{
                        if($i%2 == 0){
                            $aux = $participantes -1;
                            $aux2 = $z;
                        }else{
                            $aux = $z;
                            $aux2 = $participantes - 1;
                        }
                        $this -> creatematch($equipos[$aux2],$equipos[$aux],$arrayFechas[$dia],$profesores,$campos[0],$liga, $em);
                    }

                    $dia++;
                    $z++;
                }
            }

            $liga -> setFechaFin($arrayFechas[$dia]);
            $em -> persist($liga);
            $em -> flush();
        }
        return $this->redirect('/profesor/ligas');
    }

    private function creatematch($local,$visitante,$fecha,$profesores,$campo,$liga, $em){     
        $partido = new Partido();

        $partido->setLocal($local);
        $partido->setVisitante($visitante);
        $partido->setVigilante($profesores[rand(0, sizeof($profesores)-1)]);
        $partido->setFecha($fecha);
        $partido->setCampo($campo);
        $partido->setLiga($liga);

        try{
            $em -> persist($partido);
            $em -> flush();
        }catch(\Exception $e){

        }
    }

    /**
     * @Route("/profesor/eliminarReserva", name="delReserva")
     */
    public function delReserva(EntityManagerInterface $em)
    {
        if (isset($_POST['id'])) {
            $reserva = $em->getRepository(Reserva::class)->find($_POST['id']);

            try {
                $em->remove($reserva);
                $em->flush();
            } catch (\Throwable $th) {
                return json_encode($th);
            }

            return $this->redirect('/profesor/listarReserva');
        }
    }
}
