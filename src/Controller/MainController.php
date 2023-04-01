<?php

namespace App\Controller;

use App\Form\MainType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(MainType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //get product
         $product = $form->get('Product')->getData();
         //get price
         $price = intval($product->getPrice());
         //get Tax Number
         $taxNumber = $form->get('TaxNumber')->getData();
         //get Country Code
         $code = substr($taxNumber, 0, 2);
         //Determination of Country and Final price
         switch ($code){
             case 'DE':
                 $country = 'Germany';
                 $finalprice = $price + ($price*0.19);
                 break;
             case 'IT':
                 $country = 'Italy';
                 $finalprice = $price + ($price*0.22);
                 break;
             case 'GR':
                 $country = 'Greece';
                 $finalprice = $price + ($price*0.24);
                 break;
         }
         return $this->render('main/result.html.twig',['country'=>$country, 'finalprice'=>$finalprice]);
        }


        return $this->renderForm('main/index.html.twig', [
            'form' => $form,
        ]);
    }
}
