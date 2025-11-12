<?php

namespace App\Entity;

use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagsRepository::class)]
class Tags
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Flights::class, inversedBy: 'tags')]
    private Collection $flights;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, flights>
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flights $flight): static
    {
        if (!$this->flights->contains($flight)) {
            $this->flights->add($flight);
        }

        return $this;
    }

    public function removeFlight(Flights $flight): static
    {
        $this->flights->removeElement($flight);

        return $this;
    }
}
