<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtworkRepository::class)]
class Artwork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artistName = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $folderName = null;
    #[ORM\Column(length: 512, nullable: true)]
    private ?string $artistUrl = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imageURL = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isNSFW = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getArtistName(): ?string
    {
        return $this->artistName;
    }

    public function setArtistName(?string $artistName): static
    {
        $this->artistName = $artistName;

        return $this;
    }

    public function getArtistUrl(): ?string
    {
        return $this->artistUrl;
    }

    public function setArtistUrl(?string $artistUrl): static
    {
        $this->artistUrl = $artistUrl;

        return $this;
    }

    public function getImageURL(): ?string
    {
        return $this->imageURL;
    }

    public function setImageURL(?string $imageURL): static
    {
        $this->imageURL = $imageURL;

        return $this;
    }

    public function isNSFW(): ?bool
    {
        return $this->isNSFW;
    }

    public function setIsNSFW(?bool $isNSFW): static
    {
        $this->isNSFW = $isNSFW;

        return $this;
    }

    public function getFolderName(): ?string
    {
        return $this->folderName;
    }

    public function setFolderName(?string $folderName): void
    {
        $this->folderName = $folderName;
    }
}
