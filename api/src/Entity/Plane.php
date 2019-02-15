<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     attributes={"access_control"="is_granted('ROLE_USER')"},
 *     collectionOperations={
 *         "get",
 *         "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *          "get",
 *          "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *          "delete"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     normalizationContext={"groups"={"plane_read"}},
 *     denormalizationContext={"groups"={"plane_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PlaneRepository")
 * @UniqueEntity("number")
 */
class Plane
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
     * @Assert\Length(min=4,max=4)
     * @Groups({"company_read", "plane_read"})
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"company_read", "plane_read", "plane_write"})
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     * @Groups({"company_read", "plane_read", "plane_write"})
     */
    private $seatNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="plane", orphanRemoval=true)
     * @Groups({"plane_read"})
     */
    private $flights;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="planes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"plane_read","flight_read", "plane_write"})
     */
    private $company;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

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
            $flight->setPlane($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getPlane() === $this) {
                $flight->setPlane(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
