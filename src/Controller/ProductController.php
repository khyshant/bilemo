<?php


namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Product;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Security as SecurityAlias;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ProductController
 * @package App\Controller
 * @Route("/api/products")
 */
class ProductController
{

    /**
     * @var SecurityAlias
     */
    private $security;

    public function __construct(SecurityAlias $security)
    {
        $this->security = $security;
    }
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

    /**
     * @Route("/{id}", name="api_products_item", methods={"GET"})
     * @param Product $product
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function item(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $customer = $this->security->getUser();
        dump($customer);
        return new JsonResponse($serializer->serialize($product,"json", ["groups"=> "get"]),
            JsonResponse::HTTP_OK,
            [],
            true);
    }

/**
* @Route(name="api_users_item_add", methods={"POST"})
* @param Request $request
* @param SerializerInterface $serializer
* @param EntityManagerInterface $entityManager
* @param UrlGeneratorInterface $urlGenerator
* @return JsonResponse
    */
    public function post(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): JsonResponse
{
    $customer = $this->security->getUser();
    dump($customer);
    /** @var $product Product*/
    $product = $serializer->deserialize($request->getContent(), Product::class, 'json');
    // a supprimer quand j'aurais le retour du token
    $product->setBrand($entityManager->getRepository(Brand::class)->findOneBy([]));
    $product->setCategory($entityManager->getRepository(Category::class)->findOneBy([]));
    $entityManager->persist($product);
    $entityManager->flush();

    return new JsonResponse(
        $serializer->serialize($product,"json", ["groups"=> "get"]),
        JsonResponse::HTTP_CREATED,
        ["Location" => $urlGenerator->generate("api_users_item", ["id" => $product->getId()])],
        true);
}
}