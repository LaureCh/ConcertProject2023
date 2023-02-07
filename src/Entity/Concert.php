<?php

namespace App\Entity;

use App\Repository\ShowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShowRepository::class)]
#[ORM\Table(name: '`concert`')]
class Concert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $tourName = null;

    #[ORM\OneToOne(inversedBy: 'concert', cascade: ['persist', 'remove'])]
    private ?Hall $hall = null;

    #[ORM\ManyToMany(targetEntity: Band::class, inversedBy: 'concerts')]
    private Collection $bands;

    public function __construct()
    {
        $this->bands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTourName(): ?string
    {
        return $this->tourName;
    }

    public function setTourName(string $tourName): self
    {
        $this->tourName = $tourName;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): self
    {
        $this->hall = $hall;

        return $this;
    }

    /**
     * @return Collection<int, band>
     */
    public function getBands(): Collection
    {
        return $this->bands;
    }

    public function addBand(band $band): self
    {
        if (!$this->bands->contains($band)) {
            $this->bands->add($band);
        }

        return $this;
    }

    public function removeBand(band $band): self
    {
        $this->bands->removeElement($band);

        return $this;
    }
}
