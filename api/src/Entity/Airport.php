<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get",
 *         "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
            "get"
 *     },
 *     normalizationContext={"groups"={"airport_read"}},
 *     denormalizationContext={"groups"={"airport_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AirportRepository")
 * @UniqueEntity("name")
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
     * @Assert\NotBlank
     * @Groups({"airport_write", "airport_read", "city_read", "flight_read"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="airports")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"airport_read", "airport_write"})
     */
    private $city;

    /**
     * @ApiSubresource(maxDepth=1)
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="departureAirport", orphanRemoval=true)
     * @Groups({"airport_read", "city_read"})
     */
    private $departureFlights;

    /**
     * @ApiSubresource(maxDepth=1)
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="arrivalAirport", orphanRemoval=true)
     * @Groups({"airport_read", "city_read"})
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
