<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="products")
     */
    public function productsAction(Request $request)
    {
        $products = $this->getDoctrine()
          ->getRepository('AppBundle:Product')
          ->findAll();

        $form = $this->createFormBuilder()
          ->add('products', 'entity', [
            'class' => 'AppBundle\Entity\Product',
            'choices' => $products,
            'choice_label' => function ($value, $key, $index) {
              return $value->getName() . ': ' . $value->getPrice();
            },
            'multiple' => true,
            'required' => false,
            'expanded' => true,
          ])
          ->add('buy', 'submit', [
            'label' => 'Buy',
          ])
          ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
          $cart = $form->getData()['products'];
          $salesTaxes = 0;
          $total = 0;
          foreach ($cart as $key => $value) {
            $salesTaxes = $salesTaxes + ($value->getFullPrice() - $value->getPrice());
            $total = $total + $value->getFullPrice();
          }

          return $this->render('AppBundle::cart.html.twig', [
            'cart' => $cart,
            'salesTaxes' => $salesTaxes,
            'total' => $total
          ]);
        }

        return $this->render('AppBundle::products.html.twig', [
          'products' => $products,
          'form' => $form->createView()
        ]);
    }
}
