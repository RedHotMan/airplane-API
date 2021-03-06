<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * User entity
 *
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_USER')"},
 *         "post"={"validation_groups"={"Default", "postValidation"}}
 *     },
 *     itemOperations={
 *         "delete"={"access_control"="is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') and object == user"},
 *         "get"={"access_control"="is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') and object == user "},
 *         "put"={
 *              "access_control"="is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') and object == user",
 *              "validation_groups"={"Default", "putValidation"}
 *          },
 *          "makeUserAdmin"={
 *              "access_control"="is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') and object == user",
 *              "route_name"="make_user_admin",
 *              "swagger_context"={
 *                  "parameters"={
 *                      {
 *                          "name"="id",
 *                          "in"="path",
 *                          "required"="true",
 *                          "type"="string",
 *                      }
 *                  },
 *              },
 *          }
 *     },
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity
 * @ORM\Table(name="airplane_user")
 * @UniqueEntity(
 *     fields={"username","email"}
 * )
 */

class User implements UserInterface
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
     * @Groups({"write", "read"})
     */
    public $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email(message="Your email is not valid")
     * @Groups({"write", "read"})
     */
    public $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string PlainPassword
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="4",
     *     groups={"postValidation", "putValidation"}
     * )
     * @Assert\NotEqualTo(
     *     propertyPath="password",
     *     groups={"putValidation"}
     * )
     *
     * @Groups({"write"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json_array")
     * @Groups({"read"})
     */
    private $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $roles = $this->roles;
        if (!in_array('ROLE_USER', $roles))
        {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    public function setRoles(string $roles): self
    {
        if (!in_array($roles, $this->roles))
        {
            $this->roles[] = $roles;
        }
        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}
