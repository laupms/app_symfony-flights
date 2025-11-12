<?php

namespace App\Entity;

use App\Repository\AirlineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[UniqueEntity(fields:["name"], message: "❗️ Cette compagnie aérienne existe déjà. Ajoutez-en une nouvelle.")]
#[UniqueEntity(fields:["logo"], message: "❗️ Ce logo est déjà utilisé pour une autre compagnie. Ajoutez-en un nouveau.")]


#[ORM\Entity(repositoryClass: AirlineRepository::class)]
class Airline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }
}
