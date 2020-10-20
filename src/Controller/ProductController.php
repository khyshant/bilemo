<?php


namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * Class ProductController
 * @package App\Controller
 * @Route("/api/Products")
 */
class ProductController
{
    /**
     * @Route(name="api_products_listing", methods={"GET"})
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function listing(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {

        $customer = $this->security->getUser();
        dump($customer);
        return new JsonResponse($serializer->serialize($productRepository->findAll(),"json", ["groups"=> "get"]),
            JsonResponse::HTTP_OK,
            [],
            true);
    }
}