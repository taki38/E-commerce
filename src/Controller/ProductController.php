<?php

namespace App\Controller;

use App\classes\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/nos-produits", name="product")
     */
    public function index(Request $request): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        $search = new Search();
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $products = $this->getDoctrine()->getRepository(Product::class)->findBySearch($search);
        }
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'title' => 'Nos produits',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product_details")
     */
    public function productDetails($slug, Request $request): Response
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBySlug($slug);


        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'title' => $product->getName(),
        ]);
    }
}
