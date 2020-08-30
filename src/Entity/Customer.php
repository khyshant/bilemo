<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="user")
 * @UniqueEntity(
 *    fields={"email"},
 *     message="l'email indiqué est déjà utilisé ..."
 * )
 * @UniqueEntity(
 *    fields={"customername"},
 *     message="l'username indiqué est déjà utilisé ..."
 * )
 *
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer implements UserLoaderInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="customername", type="string", length=255, unique=true)
     */
    private $customername;

    /**
     * @var string
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="company", type="string", length=255)
     */
    private $company;

    /**
     * @var collection
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="customer", orphanRemoval=true)
     */
    private $users;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCustomername(): string
    {
        return $this->customername;
    }

    /**
     * @param string $customername
     */
    public function setCustomername(string $customername): void
    {
        $this->customername = $customername;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Comment $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCustomer($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCustomer() === $this) {
                $user->setCustomer(null);
            }
        }

        return $this;
    }

    public function loadUserByUsername(string $username)
    {
        // TODO: Implement loadUserByUsername() method.
    }

}
