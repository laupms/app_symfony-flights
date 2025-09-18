<?php

namespace App\Entity;

use App\Repository\CitiesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields:["name"], message: "❗️ Cette ville existe déjà. Ajoutez-en une nouvelle.")]

#[ORM\Entity(repositoryClass: CitiesRepository::class)]
class Cities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, name:'name')]
    private ?string $name = null;

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

    //pour renvoyer un nom (string) et pas un id (int)
    public function __toString(): string
    {
        return $this->getName();
    }

}
