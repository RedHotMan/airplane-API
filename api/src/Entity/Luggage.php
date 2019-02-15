<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     attributes={"access_control"="is_granted('ROLE_USER')"},
 *     normalizationContext={"groups"={"luggage_read"}},
 *     denormalizationContext={"groups"={"luggage_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\LuggageRepository")
 */
class Luggage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThan(1)
     * @Assert\LessThanOrEqual(12)
     * @Groups({"luggage_read", "luggage_write", "passenger_read"})
     */
    private $weight;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThan(10)
     * @Assert\LessThanOrEqual(100)
     * @Groups({"luggage_read", "luggage_write", "passenger_read"})
     */
    private $height;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Passenger", inversedBy="luggages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"luggage_read", "luggage_write"})
     */
    private $passenger;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getPassenger(): ?Passenger
    {
        return $this->passenger;
    }

    public function setPassenger(?Passenger $passenger): self
    {
        $this->passenger = $passenger;

        return $this;
    }
}
