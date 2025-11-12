<?php

namespace App\Entity;

use App\Repository\AirportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[UniqueEntity(fields:["name"], message: "❗️ Cet aéroport existe déjà. Ajoutez-en un nouveau.")]
#[UniqueEntity(fields:["code"], message: "❗️ Ce code IATA d'aéroport existe déjà. Ajoutez-en un nouveau.")]


#[ORM\Entity(repositoryClass: AirportRepository::class)]
class Airport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 4)]
    private ?string $code = null;


    #[ORM\ManyToOne(targetEntity: Cities::class, inversedBy:'name')]
    #[ORM\JoinColumn(nullable:false, name:'city_id')]
    private ?Cities $city_id = null;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = strtoupper($code);

        return $this;
    }

    public function getCityId(): ?Cities
    {
        return $this->city_id;
    }

    public function setCityId(?Cities $city_id): self
    {
        $this->city_id = $city_id;

        return $this;
    }
}
