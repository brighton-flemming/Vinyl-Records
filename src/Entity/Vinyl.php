<?php

namespace App\Entity;

use App\Repository\VinylRepository;
use Doctrine\ORM\Mapping as ORM;




#[ORM\Entity(repositoryClass: VinylRepository::class)]
#[ORM\Table(name: "tbl_records")]
class Vinyl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "record_id")]

    private ?int  $id = null;

    #[ORM\Column(length: 255)]
    private ?string $record_name = null;

    #[ORM\Column(length: 300)]
    private ?string $record_image = null;

    #[ORM\Column(length: 255)]
    private ?string $artist_name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?int $record_sequence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getRecordName(): ?string
    {
        return $this->record_name;
    }

    public function setRecordName(string $record_name): static
    {
        $this->record_name = $record_name;

        return $this;
    }

    public function getRecordImage(): ?string
    {
        return $this->record_image;
    }

    public function setRecordImage(string $record_image): static
    {
        $this->record_image = $record_image;

        return $this;
    }

    public function getArtistName(): ?string
    {
        return $this->artist_name;
    }

    public function setArtistName(string $artist_name): static
    {
        $this->artist_name = $artist_name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getRecordSequence(): ?int
    {
        return $this->record_sequence;
    }

    public function setRecordSequence(int $record_sequence): static
    {
        $this->record_sequence = $record_sequence;

        return $this;
    }

}
