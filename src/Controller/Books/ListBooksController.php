<?php

declare(strict_types=1);

namespace App\Controller\Books;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/books')]
class ListBooksController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $books = $this->em->getRepository(Book::class)->findAll();

        return $this->json($books, 200, [], ['groups' => 'book:read']);
    }
}
