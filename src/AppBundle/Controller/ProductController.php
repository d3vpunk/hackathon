<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function listAction()
    {
        $productRepository = $this->get('doctrine')->getRepository('AppBundle:Product');

        return new Response(['products' => $productRepository->findAll()]);
    }

    public function uploadAction(Request $request)
    {
        $imageForm = $this->createForm(ImageType::class);
        $imageForm->handleRequest($request);

        if ($imageForm->isSubmitted()) {
            $tags = $this->get('clarifai.client')->getTagsByImageFile($imageForm->get('file')->getData());

            $productRepository = $this->get('doctrine')->getRepository('AppBundle:Product');
            $products = $productRepository->getProductsByTags($tags);

            return new Response(['products' => $products]);
        }

        return $this->render('AppBundle:Product:upload.html.twig', [
            'imageForm' => $imageForm->createView(),
        ]);
    }
}
