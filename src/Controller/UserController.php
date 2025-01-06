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
    #[Route('/users', name: 'users_list', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(User::class);

        $users = $repository->findAll();

        return $this->json([
            'data' => $users,
        ]);
    }

    #[Route('/users/{user}', name: 'users_single', methods: ['GET'])]
    public function single(EntityManagerInterface $entityManager, int $user): JsonResponse
    {
        $repository = $entityManager->getRepository(User::class);

        $user = $repository->find($user);

        if(!$user) throw $this->createNotFoundException();

        return $this->json([
            'data' => $user
        ]);
    }

    #[Route('/users', name: 'users_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        if($request->headers->get('Content-Type') == 'application/json'){
            $data = $request->toArray();
        } else {
            $data = $request->request->all();
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setCreatedAt(new \DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')));
        $user->setUpdatedAt(new \DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')));

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->json([
            'message' => 'usuario criado com o id '.$user->getId(),
        ], 201);
    }

    #[Route('/users/{user}', name: 'users_update', methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager, int $user): JsonResponse
    {
        $repository = $entityManager->getRepository(User::class);

        $user = $repository->find($user);

        if(!$user) throw $this->createNotFoundException();

        if($request->headers->get('Content-Type') == 'application/json'){
            $data = $request->toArray();
        } else {
            $data = $request->request->all();
        }

        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setUpdatedAt(new \DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo')));

        $entityManager->persist($user);

        $entityManager->flush();


        return $this->json([
            'data' => $user
        ]);
    }

    #[Route('/users/{user}', name: 'users_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, int $user): JsonResponse
    {
        $repository = $entityManager->getRepository(User::class);

        $user = $repository->find($user);

        if(!$user) throw $this->createNotFoundException();

        $entityManager->remove($user);

        $entityManager->flush();

        return $this->json([
            'message' => 'usuario '.$user->getName().' deletado com sucesso'
        ]);
    }
}
