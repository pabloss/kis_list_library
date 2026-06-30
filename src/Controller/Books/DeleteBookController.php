<?php

declare(strict_types=1);

namespace App\Controller\Books;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/books')]
class DeleteBookController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function __invoke(int $id): JsonResponse
    {
        $book = $this->em->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        $this->em->remove($book);
        $this->em->flush();

        return $this->json(null, 204);
    }
}
