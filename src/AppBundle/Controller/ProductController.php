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
        return new Response();
    }

    public function uploadAction(Request $request)
    {
        $imageForm = $this->createForm(ImageType::class);
        $imageForm->handleRequest($request);

        if ($imageForm->isSubmitted()) {
            $imageAiRatings = $this->get('clarifai.client')->getTagsByImageFile($imageForm->get('file')->getData());
        }

        return $this->render('AppBundle:Product:upload.html.twig', [
            'imageForm' => $imageForm->createView(),
        ]);
    }


}
