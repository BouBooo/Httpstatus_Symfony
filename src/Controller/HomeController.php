<?php

namespace App\Controller;

use App\Repository\StatusRepository;
use App\Repository\WebsiteRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(WebsiteRepository $repo, StatusRepository $statusRepo)
    {
        $websites = $repo->findAll();
        $count = count($websites);
        return $this->render('home/index.html.twig', [
            'websites' => $repo->findAll(),
            'status' => $statusRepo->getLastStatus($count)
        ]);
    }
}
