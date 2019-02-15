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
 *         "post"
 *     },
 *     itemOperations={
 *         "get"
 *     },
 *     normalizationContext={"groups"={"city_read"}},
 *     denormalizationContext={"groups"={"city_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 * @UniqueEntity(
 *     fields={"name", "zipCode"}
 * )
 */
class City
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
     * @Groups({"city_write", "city_read", "airport_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"city_write", "city_read", "airport_read", "flight_read"})
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"city_write", "city_read", "airport_read", "flight_read"})
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Airport", mappedBy="city", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     * @Groups({"city_read"})
     */
    private $airports;

    public function __construct()
    {
        $this->airports = new ArrayCollection();
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

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Airport[]
     */
    public function getAirports(): Collection
    {
        return $this->airports;
    }

    public function addAirport(Airport $airport): self
    {
        if (!$this->airports->contains($airport)) {
            $this->airports[] = $airport;
            $airport->setCity($this);
        }

        return $this;
    }

    public function removeAirport(Airport $airport): self
    {
        if ($this->airports->contains($airport)) {
            $this->airports->removeElement($airport);
            // set the owning side to null (unless already changed)
            if ($airport->getCity() === $this) {
                $airport->setCity(null);
            }
        }

        return $this;
    }
}
