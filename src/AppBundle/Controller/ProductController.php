<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    /**
     * @return Response
     */
    public function listAction()
    {
        $productRepository = $this->get('doctrine')->getRepository('AppBundle:Product');
        $products = $productRepository->findBy([], ['popularity' => 'DESC'], 10);

        return new Response($this->get('jms_serializer')->serialize($products), 'json');
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function uploadAction(Request $request)
    {
        $imageForm = $this->createForm(ImageType::class);
        $imageForm->handleRequest($request);

        if ($imageForm->isSubmitted()) {
            $mediaTags = $this->get('clarifai.client')->getTagsByImageFile($imageForm->get('file')->getData());

            $productTagRepository = $this->get('doctrine')->getRepository('AppBundle:ProductTag');
            $products = $productTagRepository->getProductsByMediaTags($mediaTags);

            return new Response($this->get('jms_serializer')->serialize($products, 'json'));
        }

        return $this->render('AppBundle:Product:upload.html.twig', [
            'imageForm' => $imageForm->createView(),
        ]);
    }
}
