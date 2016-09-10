<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Product;
use AppBundle\Form\Type\ImageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findBy([], ['title' => 'asc']);

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Finds and displays a Product entity.
     *
     */
    public function showAction(Product $product)
    {

        return $this->render('product/show.html.twig', array(
            'product' => $product,
        ));
    }


    /**
     * @return Response
     */
    public function listAction()
    {
        $productRepository = $this->get('doctrine')->getRepository('AppBundle:Product');
        $products = $productRepository->findBy([], ['popularity' => 'DESC'], 10);

        return new Response($this->get('jms_serializer')->serialize($products, 'json'));
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
        $productRepository = $this->get('doctrine')->getRepository('AppBundle:Product');

        if ($imageForm->isSubmitted()) {
            $mediaTags = $this->get('clarifai.client')->getTagsByImageFile($imageForm->get('file')->getData());

            $productTagRepository = $this->get('doctrine')->getRepository('AppBundle:ProductTag');
            $matches = $productRepository->getProductsByMediaTags($mediaTags);

            $products = [];
            foreach($matches as $match) {
                if ($match["total_score"] < 1.3) {
                    continue;
                }
                $products[] = $match['product'];
            }

            return new Response($this->get('jms_serializer')->serialize($products, 'json'));
        }

        return $this->render('AppBundle:Product:upload.html.twig', [
            'imageForm' => $imageForm->createView(),
        ]);
    }

    public function tagAction(Request $request)
    {
        $imageForm = $this->createForm(ImageType::class);
        $imageForm->handleRequest($request);

        if ($imageForm->isSubmitted()) {
            $mediaTags = $this->get('clarifai.client')->getTagsByImageFile($imageForm->get('file')->getData());

            return new Response($this->get('jms_serializer')->serialize($mediaTags, 'json'));
        }

        return $this->render('AppBundle:Product:upload.html.twig', [
            'imageForm' => $imageForm->createView(),
        ]);
    }
}
