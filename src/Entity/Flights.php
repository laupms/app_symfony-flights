<?php

namespace App\Entity;
use App\Entity\Airline;
use App\Entity\Airport;

use App\Repository\FlightsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;



#[ORM\Entity(repositoryClass: FlightsRepository::class)]
class Flights
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\GeneratedValue]
    #[ORM\Column(length: 6)]
    private ?string $num = null;

    #[ORM\ManyToOne(targetEntity: Airline::class, inversedBy:'name')]
    #[ORM\JoinColumn(nullable:false, name:'airline')]
    private $airline = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $departure = null;


    //pour vérifier que l'aéroport de départ soit différent de l'aéroport d'arrivé
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        if ($this->airport_departure && $this->airport_arrival && $this->airport_departure === $this->airport_arrival) {
            $context->buildViolation("❗️ La ville d'arrivée doit être différente de la ville de départ.")
                ->atPath('airport_arrival') // le message sera affiché sous le champ de la ville d’arrivée
                ->addViolation();
        }
    }

    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy:'name')]
    #[ORM\JoinColumn(nullable:false, name:'airport_departure')]
    private $airport_departure = null;



    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $arrival = null;


    //pour vérifier que la date/heure d'arrivée soit postérieure à la date/heure de départ
    #[Assert\Callback]
    public function validateDates(ExecutionContextInterface $context): void{
        if ($this->departure && $this->arrival) {
            if ($this->departure >= $this->arrival) {
                $context->buildViolation("❗️ La date et l'heure d'arrivée doivent être postérieures à la date et l'heure de départ.")
                    ->atPath('arrival') // le message sera affiché sous le champs de la date/heure de l'arrivée
                    ->addViolation();
    }}}

    #[ORM\ManyToOne(targetEntity: Airport::class, inversedBy:'name')]
    #[ORM\JoinColumn(nullable:false, name:'airport_arrival')]
    private $airport_arrival = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column]
    private ?int $nb_seat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceAfterDiscount = null;

    #[ORM\ManyToMany(targetEntity: Tags::class, mappedBy: 'flights')]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(string $num): static
    {
        $this->num = $num;

        return $this;
    }

    public function getAirline(): ?Airline
    {
        return $this->airline;
    }

    public function setAirline(?Airline $airline): self
    {
        $this->airline = $airline;

        return $this;
    }

    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

    public function setDeparture(\DateTimeInterface $departure): static
    {
        $this->departure = $departure;

        return $this;
    }

    public function getAirportDeparture()
    {
        return $this->airport_departure;
    }

    public function setAirportDeparture($airport_departure): static
    {
        $this->airport_departure = $airport_departure;

        return $this;
    }

    public function getArrival(): ?\DateTimeInterface
    {
        return $this->arrival;
    }

    public function setArrival(\DateTimeInterface $arrival): static
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getAirportArrival()
    {
        return $this->airport_arrival;
    }

    public function setAirportArrival($airport_arrival): static
    {
        $this->airport_arrival = $airport_arrival;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getNbSeat(): ?int
    {
        return $this->nb_seat;
    }

    public function setNbSeat(int $nb_seat): static
    {
        $this->nb_seat = $nb_seat;

        return $this;
    }

    public function getPriceAfterDiscount(): ?string
    {
        return $this->priceAfterDiscount;
    }

    public function setPriceAfterDiscount(string $priceAfterDiscount): static
    {
        $this->priceAfterDiscount = $priceAfterDiscount;

        return $this;
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addFlight($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeFlight($this);
        }

        return $this;
    }
}
