<?php

declare(strict_types=1);

namespace App\Entity;


class Book
{

    private ?int $id = null;

    private ?string $serialNumber = null;

    private ?string $title = null;

    private ?string $author = null;


    private bool $isBorrowed = false;

    private ?\DateTimeInterface $borrowedAt = null;

    private ?string $borrowedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function isBorrowed(): bool
    {
        return $this->isBorrowed;
    }

    public function setIsBorrowed(bool $isBorrowed): self
    {
        $this->isBorrowed = $isBorrowed;
        return $this;
    }

    public function getBorrowedAt(): ?\DateTimeInterface
    {
        return $this->borrowedAt;
    }

    public function setBorrowedAt(?\DateTimeInterface $borrowedAt): self
    {
        $this->borrowedAt = $borrowedAt;
        return $this;
    }

    public function getBorrowedBy(): ?string
    {
        return $this->borrowedBy;
    }

    public function setBorrowedBy(?string $borrowedBy): self
    {
        $this->borrowedBy = $borrowedBy;
        return $this;
    }
}
