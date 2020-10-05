<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * Class BrandController
 * @package App\Controller
 * @Route("/api/users")
 */
class UserController
{

    /**
     * @Route(name="api_users_listing", methods={"GET"})
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function listing(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {

        return new JsonResponse($serializer->serialize($userRepository->findAll(),"json", ["groups"=> "get"]),
        JsonResponse::HTTP_OK,
        '',
        true);
    }

    /**
     * @Route("/{id}" name="api_users_item", methods={"GET"})
     * @param User $user
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function item(User $user, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse($serializer->serialize($user,"json", ["groups"=> "get"]),
            JsonResponse::HTTP_OK,
            '',
            true);
    }

    /**
     * @Route(name="api_users_item_add", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function user(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($user->findAll(),"json", ["groups"=> "get"]),
            JsonResponse::HTTP_CREATED,
            '',
            true);
    }
}