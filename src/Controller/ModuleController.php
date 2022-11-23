<?php

namespace App\Controller;

use App\Entity\ModuleFormation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    /**
     * @Route("/module", name="app_module")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $modules = $doctrine->getRepository(ModuleFormation::class)->findAll();

        return $this->render('module/index.html.twig', [
            'modules' => 'modules',
        ]);
    }

    /**
     * @Route("/module/{id}", name="show_module")
     */
    public function show(ModuleController $module): Response
    {

        return $this->render('module/show.html.twig', [
            'module' => $module,
        ]);
    }
}
