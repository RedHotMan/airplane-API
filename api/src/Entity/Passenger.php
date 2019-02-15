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
 *     attributes={"access_control"="is_granted('ROLE_USER')"},
 *     collectionOperations={
 *         "get",
 *         "post"={"validation_groups"={"Default", "postValidation"}}
 *     },
 *     itemOperations={
 *         "delete",
 *         "get",
 *         "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"passenger_read"}},
 *     denormalizationContext={"groups"={"passenger_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PassengerRepository")
 * @UniqueEntity(
 *     fields={"lastname","firstname"}
 * )
 */
class Passenger
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
     * @Groups({"passenger_read","passenger_write", "company_read", "luggage_read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"passenger_read","passenger_write", "company_read", "luggage_read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\Datetime
     * @Assert\LessThan("-10 years")
     * @Groups({"passenger_read","passenger_write"})
     */
    private $birthdate;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Choice(choices={true, false})
     * @Groups({"passenger_read","passenger_write", "company_read", "luggage_read"})
     */
    private $gender;

    /**
     * @ApiSubresource(maxDepth=1)
     * @ORM\OneToMany(targetEntity="App\Entity\Luggage", mappedBy="passenger")
     * @Groups({"passenger_read", "company_read"})
     */
    private $luggages;

    /**
     * @ApiSubresource(maxDepth=1)
     * @ORM\ManyToMany(targetEntity="App\Entity\Flight", mappedBy="passengers")
     * @Groups({"passenger_read", "company_read", "passenger_write"})
     */
    private $flights;

    public function __construct()
    {
        $this->luggages = new ArrayCollection();
        $this->flights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection|Luggage[]
     */
    public function getLuggages(): Collection
    {
        return $this->luggages;
    }

    public function addLuggage(Luggage $luggage): self
    {
        if (!$this->luggages->contains($luggage)) {
            $this->luggages[] = $luggage;
            $luggage->setPassenger($this);
        }

        return $this;
    }

    public function removeLuggage(Luggage $luggage): self
    {
        if ($this->luggages->contains($luggage)) {
            $this->luggages->removeElement($luggage);
            // set the owning side to null (unless already changed)
            if ($luggage->getPassenger() === $this) {
                $luggage->setPassenger(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights[] = $flight;
            $flight->addPassenger($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            $flight->removePassenger($this);
        }

        return $this;
    }
}
