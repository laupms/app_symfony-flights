<?php

namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: DiscountRepository::class)]
class Discount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Airline::class, inversedBy:'name')]
    #[ORM\JoinColumn(nullable:false, name:'airline')]
    private $airline = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $value = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_start = null;

    //pour vérifier que la date/heure d'arrivée soit postérieure à la date/heure de départ
    #[Assert\Callback]
    public function validateDates(ExecutionContextInterface $context): void{
        if ($this->date_start && $this->date_end) {
            if ($this->date_start >= $this->date_end) {
                $context->buildViolation("❗️ La date de fin doit être postérieure à la date de début de la réduction.")
                    ->atPath('date_end') // le message sera affiché sous le champs de la date/heure de fin
                    ->addViolation();
    }}}

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_end = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): static
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): static
    {
        $this->date_end = $date_end;

        return $this;
    }
}
