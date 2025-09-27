<?php

namespace App\Entity;

use App\Repository\InfoCardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoCardRepository::class)]
class InfoCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $cardBody = null;

    #[ORM\Column]
    private ?int $colSize = null;

    #[ORM\Column]
    private ?int $ordering = null;
    #[ORM\Column]
    private ?int $colOffset = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCardBody(): ?string
    {
        return $this->cardBody;
    }

    public function setCardBody(string $cardBody): static
    {
        $this->cardBody = $cardBody;

        return $this;
    }

    public function getColSize(): ?int
    {
        return $this->colSize;
    }

    public function setColSize(int $colSize): static
    {
        $this->colSize = $colSize;

        return $this;
    }

    public function getOrdering(): ?int
    {
        return $this->ordering;
    }

    public function setOrdering(int $ordering): static
    {
        $this->ordering = $ordering;

        return $this;
    }

    public function getColOffset(): ?int
    {
        return $this->colOffset;
    }

    public function setColOffset(?int $colOffset): void
    {
        $this->colOffset = $colOffset;
    }
}
