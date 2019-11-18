<?php

namespace App\Controller;

use App\Repository\StatusRepository;
use App\Repository\WebsiteRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(WebsiteRepository $repo, StatusRepository $statusRepo)
    {
        $websites = $repo->findAll();
        $count = count($websites);
        return $this->render('admin/index.html.twig', [
            'websites' => $repo->findAll(),
            'status' => $statusRepo->getLastStatus($count)
        ]);
    }

    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        
        return $this->render('admin/login.html.twig', [
            'error' => $error !== null,
            'username' => $username
        ]);
    }


    /**
     * @Route("/admin/logout", name="admin_logout")
     */
    public function logout() {
        // Logout function can be empty
    }
}
