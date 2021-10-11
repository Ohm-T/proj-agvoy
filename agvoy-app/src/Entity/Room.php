<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="rooms")
     */
    private $room;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="float")
     */
    private $superficy;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity=Region::class, mappedBy="region")
     */
    private $regions;

    /**
     * @ORM\OneToOne(targetEntity=Reservation::class, mappedBy="room", cascade={"persist", "remove"})
     */
    private $reservation;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="room")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity=UnavailablePeriod::class, mappedBy="room")
     */
    private $unavailablePeriods;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->unavailablePeriods = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?Owner
    {
        return $this->room;
    }

    public function setRoom(?Owner $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getSuperficy(): ?float
    {
        return $this->superficy;
    }

    public function setSuperficy(float $superficy): self
    {
        $this->superficy = $superficy;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Region[]
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
            $region->addRegion($this);
        }

        return $this;
    }

    public function removeRegion(Region $region): self
    {
        if ($this->regions->removeElement($region)) {
            $region->removeRegion($this);
        }

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): self
    {
        // set the owning side of the relation if necessary
        if ($reservation->getRoom() !== $this) {
            $reservation->setRoom($this);
        }

        $this->reservation = $reservation;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setRoom($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRoom() === $this) {
                $reservation->setRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UnavailablePeriod[]
     */
    public function getUnavailablePeriods(): Collection
    {
        return $this->unavailablePeriods;
    }

    public function addUnavailablePeriod(UnavailablePeriod $unavailablePeriod): self
    {
        if (!$this->unavailablePeriods->contains($unavailablePeriod)) {
            $this->unavailablePeriods[] = $unavailablePeriod;
            $unavailablePeriod->setRoom($this);
        }

        return $this;
    }

    public function removeUnavailablePeriod(UnavailablePeriod $unavailablePeriod): self
    {
        if ($this->unavailablePeriods->removeElement($unavailablePeriod)) {
            // set the owning side to null (unless already changed)
            if ($unavailablePeriod->getRoom() === $this) {
                $unavailablePeriod->setRoom(null);
            }
        }

        return $this;
    }
}
