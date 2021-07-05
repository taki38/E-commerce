<?php

namespace App\Controller;

use App\classes\Cart;
use App\Entity\Adress;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdressController extends AbstractController
{
    /**
     * @Route("/compte/adresses", name="account_adress")
     */
    public function index(): Response
    {
        return $this->render('account/adress.html.twig', [
            'title' => 'Mes adresses',
        ]);
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_address_add")
     */
    public function addAdress(Cart $cart, Request $request, EntityManagerInterface $entityManager)
    {
        $address = new Adress();

        $form = $this->createForm(AdressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $entityManager->persist($address);
            $entityManager->flush();
            if ($cart->get()) {
                return $this->redirectToRoute('home');
            } else {
                return $this->redirectToRoute('account_address');
            }
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter une adresse'
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_address_edit")
     */
    public function editAdress(Cart $cart, Request $request, EntityManagerInterface $entityManager, $id)
    {
        $adress = $this->getDoctrine()->getRepository(Adress::class)->findOneById($id);

        if (!$adress || $adress->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                $entityManager->flush();

                return $this->redirectToRoute('account_adress');

        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier mon adresse'
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_address_delete")
     */
    public function deleteAdress(Request $request, EntityManagerInterface $entityManager, $id)
    {
        $adress = $this->getDoctrine()->getRepository(Adress::class)->findOneById($id);
        if ($adress && $adress->getUser() == $this->getUser()) {
            $entityManager->remove($adress);
            $entityManager->flush();

        }

        return $this->render('account/address.html.twig', [

        ]);
    }



}
