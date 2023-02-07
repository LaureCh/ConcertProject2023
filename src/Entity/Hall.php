<?php

namespace App\Entity;

use App\Repository\HallRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HallRepository::class)]
class Hall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column]
    private ?bool $available = null;

    #[ORM\ManyToOne(inversedBy: 'halls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ConcertHall $concertHall = null;

    #[ORM\OneToOne(mappedBy: 'hall', cascade: ['persist', 'remove'])]
    private ?Concert $concert = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getConcertHall(): ?ConcertHall
    {
        return $this->concertHall;
    }

    public function setConcertHall(?ConcertHall $concertHall): self
    {
        $this->concertHall = $concertHall;

        return $this;
    }

    public function getConcert(): ?Concert
    {
        return $this->concert;
    }

    public function setConcert(?Concert $concert): self
    {
        // unset the owning side of the relation if necessary
        if ($concert === null && $this->concert !== null) {
            $this->concert->setHall(null);
        }

        // set the owning side of the relation if necessary
        if ($concert !== null && $concert->getHall() !== $this) {
            $concert->setHall($this);
        }

        $this->concert = $concert;

        return $this;
    }
}
