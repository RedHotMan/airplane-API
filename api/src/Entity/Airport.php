<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AirportRepository")
 */
class Airport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="airports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="departureAirport", orphanRemoval=true)
     */
    private $departureFlights;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="arrivalAirport", orphanRemoval=true)
     */
    private $arrivalFlights;

    public function __construct()
    {
        $this->departureFlights = new ArrayCollection();
        $this->arrivalFlights = new ArrayCollection();
    }

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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getDepartureFlights(): Collection
    {
        return $this->departureFlights;
    }

    public function addDepartureFlight(Flight $departureFlight): self
    {
        if (!$this->departureFlights->contains($departureFlight)) {
            $this->departureFlights[] = $departureFlight;
            $departureFlight->setDepartureAirport($this);
        }

        return $this;
    }

    public function removeDepartureFlight(Flight $departureFlight): self
    {
        if ($this->departureFlights->contains($departureFlight)) {
            $this->departureFlights->removeElement($departureFlight);
            // set the owning side to null (unless already changed)
            if ($departureFlight->getDepartureAirport() === $this) {
                $departureFlight->setDepartureAirport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getArrivalFlights(): Collection
    {
        return $this->arrivalFlights;
    }

    public function addArrivalFlight(Flight $arrivalFlight): self
    {
        if (!$this->arrivalFlights->contains($arrivalFlight)) {
            $this->arrivalFlights[] = $arrivalFlight;
            $arrivalFlight->setArrivalAirport($this);
        }

        return $this;
    }

    public function removeArrivalFlight(Flight $arrivalFlight): self
    {
        if ($this->arrivalFlights->contains($arrivalFlight)) {
            $this->arrivalFlights->removeElement($arrivalFlight);
            // set the owning side to null (unless already changed)
            if ($arrivalFlight->getArrivalAirport() === $this) {
                $arrivalFlight->setArrivalAirport(null);
            }
        }

        return $this;
    }
}
