<?php

namespace App\Controller;

use App\Entity\Website;
use App\Repository\StatusRepository;
use App\Repository\WebsiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function api(Request $request) {
        $key = $request->get('apikey') ?? false;
        if($key === $this->getUser()->getApiKey()) {
            return new JsonResponse([
                'success' => true,
                'access' => $this->getUser()->getEmail(),
                'routes' => [
                    '127.0.0.1:8000/api' => 'Home page',
                    '127.0.0.1:8000/api/list' => 'List all websites',
                    '127.0.0.1:8000/api/list/{id}' => 'List one specific website'
                ]
            ]);
        }
        return new JsonResponse([
            'error' => 'Wrong Api key'
        ]);
    }

    /**
     * @Route("/api/websites", name="api_list")
     */
    public function index(WebsiteRepository $repo, Request $request)
    {
        if($request->get('apikey') === $this->getUser()->getApiKey()) {
            return new JsonResponse([
                'websites' => $repo->findAllArray()
            ]);
        }
        return new JsonResponse([
            'error' => 'Wrong Api key'
        ]);
    }

    /**
     * @Route("/api/websites/{id}", name="api_list_index")
     */
    public function show(Website $website)
    {
        $array = (array) $website;
        return new JsonResponse([
            'website' => $array
        ]);
    }

    /**
     * @Route("/api/websites/{id}/status", name="api_website_status")
     */
    public function apiWebsiteStatus(Website $website, StatusRepository $repo) {
        $lastStatus = $repo->getLastWebsiteStatus($website);
        return new JsonResponse([
            'status' => $lastStatus['0']->getCode(),
            'website' => $website->getUrl()
        ]);
    }

    /**
     * @Route("/api/history", name="api_history")
     */
    public function history(StatusRepository $statusRepo) {

        return new JsonResponse([
            'history' => $statusRepo->findAllArray()
        ]);
    }
}
