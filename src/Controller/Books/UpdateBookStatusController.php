<?php

declare(strict_types=1);

namespace App\Controller\Books;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/books')]
class UpdateBookStatusController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly ValidatorInterface $validator)
    {
    }

    #[Route('/{id}/status', methods: ['PATCH'])]
    public function __invoke(int $id, Request $request): JsonResponse
    {
        $book = $this->em->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if (!isset($data['isBorrowed'])) {
            return $this->json(['error' => 'Missing isBorrowed field'], 400);
        }

        $isBorrowed = filter_var($data['isBorrowed'], FILTER_VALIDATE_BOOLEAN);
        $book->setIsBorrowed($isBorrowed);

        if ($isBorrowed) {
            $borrowedBy = $data['borrowedBy'] ?? null;
            $book->setBorrowedAt(new \DateTime());
            $book->setBorrowedBy($borrowedBy);
        } else {
            $book->setBorrowedAt(null);
            $book->setBorrowedBy(null);
        }

        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
            return $this->json(['error' => $errorMessages], 400);
        }

        $this->em->flush();

        return $this->json($book, 200, [], ['groups' => 'book:read']);
    }
}
