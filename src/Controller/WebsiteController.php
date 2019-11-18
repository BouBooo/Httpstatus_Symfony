<?php

namespace App\Controller;

use DateTime;
use App\Entity\Status;
use App\Entity\Website;
use App\Repository\StatusRepository;
use App\Repository\WebsiteRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebsiteController extends AbstractController
{
    /**
     * @Route("/websites/analyze", name="check_status")
     */
    public function analyze(WebsiteRepository $repo, ObjectManager $manager) {
        $websites = $repo->findAll();

        foreach($websites as $key => $website) {
            $headers = get_headers($website->getUrl(),1);
            $headers['Http-Response'] = $headers[0];

            if($headers['Http-Response'] = 'HTTP/1.1 200 OK') {
                $http_code = 200;
            }

            $status = new Status();
            $status->setCode($http_code)
                    ->setWebsite($website)
                    ->setDateReport(new \DateTime());
            $manager->persist($status);
        }

        $manager->flush();

        $this->addFlash('success', 'Votre diagnostic a été effectué avec succès.');
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/websites/clean", name="clean_history")
     */
    public function clean(StatusRepository $repo) {
        $repo->cleanStatusHistory();
        $this->addFlash('warning', 'Historique des diagnostics effacé avec succès');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/websites/test", name="test")
     */
    public function test(WebsiteRepository $repo, ObjectManager $manager) {
        foreach ($repo->findAll() as $key => $site) {
            $url = $site->getUrl();
            $handle = curl_init($url);
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($handle);
            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            curl_close($handle);

            $status = new Status();
            $status->setWebsite($site)
                    ->setCode($code)
                    ->setDateReport(new \DateTime());
            $manager->persist($status);
        }
        $manager->flush();

        $this->addFlash('success', 'Votre diagnostic a été effectué avec succès.');
        return $this->redirectToRoute('admin');
    }

    
    /**
     * @Route("/websites/{id}", name="website_view")
     */
    public function index(Website $website)
    {
        
        return $this->render('website/index.html.twig', compact('website'));
    }

    
}
