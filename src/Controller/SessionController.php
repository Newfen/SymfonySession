<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Programme;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Form\ProgrammeType;
use App\Repository\StagiaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\ManagerRegistry as DoctrineManagerRegistry;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="app_session")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findAll();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

     /**
     * @Route("/session/add", name="add_session")
     * @Route("/session/update/{id}", name="update_session")
     */
    public function add(ManagerRegistry $doctrine, Session $session = null, Request  $request): Response
    {
        if(!$session) {
            $session = new Session();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/add.html.twig', [
            'formSession' => $form->createView()

        ]);
    }

       
    /**
     * @Route("/session/addProgramme", name="add_programme")
     */
    public function addProgramme(ManagerRegistry $doctrine, Programme $programme = null, Request $request): Response
    {

        if (!$programme) {
            $programme = new Programme();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $programme = $form->getData();
            $entityManager->persist($programme);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/addProgramme.html.twig', [
            'formProgramme' => $form->createView()
        ]);
    }


    /**
     * @Route("/session/delete/{id}", name="delete_session")
     */
    public function delete(ManagerRegistry $doctrine, Session $session)
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute("app_session");
    }


    /**
     * @Route("/session/{id}", name="show_session")
     */
    public function show(ManagerRegistry $doctrine, Session $session, StagiaireRepository $sta): Response
    {

        $nonInscrits = $sta->getNonInscrits($session->getId());

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'nonInscrits' => $nonInscrits,
        ]);
    }

    /**
     * @Route("/session/inscrire/{idSession}/{idStagiaire}", name="programmer_session")
     * 
     * @ParamConverter("session", options={"mapping": {"idSession" : "id"}})
     * @ParamConverter("stagiaire", options={"mapping": {"idStagiaire" : "id"}})
     */
    public function programmer(ManagerRegistry $doctrine, Session $session, Stagiaire $stagiaire)
    {
        if ($session->getPlaceRestante() > 0){
            $session->addStagiaire($stagiaire);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('show_session', ['id'=>$session->getId()]);
        }
    }


    /**
     * @Route("/session/deleteStagiaire/{idSession}/{idStagiaire}", name="deprogrammer_session")
     * 
     * @ParamConverter("session", options={"mapping": {"idSession" : "id"}})
     * @ParamConverter("stagiaire", options={"mapping": {"idStagiaire" : "id"}})
     */
    public function deprogrammer(ManagerRegistry $doctrine, Session $session, Stagiaire $stagiaire)
    {
            $session->removeStagiaire($stagiaire);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('show_session', ['id'=>$session->getId()]);
        }

    /**
     * @Route("/session/deleteProgramme/{idSession}/{idProgramme}", name="delete_programme_session")
     *
     * @ParamConverter("session", options={"mapping" = {"idSession" : "id"}})
     * @ParamConverter("programme", options={"mapping" = {"idProgramme" : "id"}})
     */
    public function deleteProgramme(ManagerRegistry $doctrine, Programme $programme, Session $session)
    {
        $entityManager = $doctrine->getManager();
        $session->removeProgramme($programme);

        $entityManager->persist($session);
        $entityManager->flush();
        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
    }
}
