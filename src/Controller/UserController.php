<?php


namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
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
 * Class BrandController
 * @package App\Controller
 * @Route("/api/users")
 */
class UserController
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
     * @Route(name="api_users_listing", methods={"GET"})
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function listing(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {

        $customer = $this->security->getUser();
        dump($customer);
        return new JsonResponse($serializer->serialize($userRepository->findAll(),"json", ["groups"=> "get"]),
        JsonResponse::HTTP_OK,
        [],
        true);
    }

    /**
     * @Route("/{id}", name="api_users_item", methods={"GET"})
     * @param User $user
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function item(User $user, SerializerInterface $serializer): JsonResponse
    {
        $customer = $this->security->getUser();
        dump($customer);
        return new JsonResponse($serializer->serialize($user,"json", ["groups"=> "get"]),
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
        /** @var $user User*/
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        // a supprimer quand j'aurais le retour du token
        $user->setCustomer($entityManager->getRepository(Customer::class)->findOneBy([]));
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($user,"json", ["groups"=> "get"]),
            JsonResponse::HTTP_CREATED,
            ["Location" => $urlGenerator->generate("api_users_item", ["id" => $user->getId()])],
            true);
    }

    /**
     * @Route("/{id}",name="api_users_item_modify", methods={"PUT"})
     * @IsGranted("edit",subject="user")

     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function put(User $user, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $customer = $this->security->getUser();
        dump($customer);
        /** @var $user User*/
        $serializer->deserialize($request->getContent(), User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE =>$user]);
        // a supprimer quand j'aurais le retour du token
        $user->setCustomer($entityManager->getRepository(Customer::class)->findOneBy([]));

        $entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{id}",name="api_users_item_delete", methods={"DELETE"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function delete(User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $customer = $this->security->getUser();
        dump($customer);
        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT);
    }
}