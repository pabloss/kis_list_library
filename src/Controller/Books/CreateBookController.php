<?php

declare(strict_types=1);

namespace App\Controller\Books;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/books')]
class CreateBookController extends AbstractController
{
    public function __construct(
        readonly private SerializerInterface $serializer,
        readonly private EntityManagerInterface $em,
        readonly private ValidatorInterface $validator
    )
    {
    }

    #[Route('', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $book = $this->serializer->deserialize($request->getContent(), Book::class, 'json');
        } catch (\Exception $e) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
            return $this->json(['error' => $errorMessages], 400);
        }

        $this->em->persist($book);
        $this->em->flush();

        return $this->json($book, 201, [], ['groups' => 'book:read']);
    }
}
