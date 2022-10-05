<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $produits = $doctrine->getRepository(Produit::class)->findBy(['actif' => true]);

        return $this->render("site/index.html.twig", ["produits" => $produits]);
    }

    #[Route('/panier', name: 'panier')]
    public function panier()
    {
        return $this->render("site/panier.html.twig");
    }
    #[Route('/produit/{id}-{url}', name: 'produit', requirements: ['id' => '\d+', 'url' => '.{1,}'])]
    // #[ParamConverter('Produit', class: Produit::class)]
    public function show(Produit $produit): Response
    {
        return $this->render("site/produit.html.twig", ["produit" => $produit]);
    }

    public function menu()
    {
        $listMenu = array(
            array('title' => 'Ma boutique', 'text' => 'Accueil', 'url' => $this->generateUrl('home', [], UrlGeneratorInterface::ABSOLUTE_URL)),
            array('title' => 'Mon Panier', 'text' => 'Mon Panier', 'url' => "/panier")
        );
        return $this->render("parts/menu.html.twig", array('listMenu' => $listMenu));
    }
}
