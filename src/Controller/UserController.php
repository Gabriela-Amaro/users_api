<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(User::class);

        $users = $repository->findAll();

        return $this->json([
            'data' => $users,
        ]);
    }

    #[Route('/user', name: 'create_user', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = $request->request->all();

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setCreatedAt(new \DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')));
        $user->setUpdatedAt(new \DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')));

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->json([
            'message' => 'usuario criado com o id '.$user->getId()
        ], 201);
    }
}
