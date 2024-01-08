<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_user", "get_follower", "get_association", "get_message", "get_chanel", "get_my_chanel", "get_my_follower"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"get_user", "get_follower", "get_association", "get_message", "get_chanel", "get_my_chanel"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_user", "get_follower", "get_association", "get_message", "get_chanel", "get_my_chanel"})
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $password;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"get_user", "get_follower", "get_association", "get_message", "get_chanel", "get_my_chanel"})
     */
    private $userPhoto;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"get_user", "get_follower", "get_association", "get_message", "get_chanel", "get_my_chanel"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="Chanel", mappedBy="users")
     * @Groups({"get_user", "get_follower", "get_association"})
     */
    private $chanels;

    /**
     * @ORM\OneToMany(targetEntity="Association", mappedBy="user")
     */
    private $associations;
    
    private $plainPassword;

    private $roles = [];

    public function __construct()
    {
        $this->chanels = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    public function eraseCredentials()
    {
       
    }

    public function getRole()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getSalt()
    {
        
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserPhoto(): ?string
    {
        return $this->userPhoto;
    }

    public function setUserPhoto(?string $userPhoto): self
    {
        $this->userPhoto = $userPhoto;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {   
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {   
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {   
        $this->password = $password;
        return $this;
    }

    public function addChanel(Chanel $chanel): self
    {
        if (!$this->chanels->contains($chanel)) {
            $this->chanels[] = $chanel;
            $chanel->addUser($this); 
        }

        return $this;
    }

    public function getChanels(): Collection
    {
        return $this->chanels;
    }

    public function removeChanel(Chanel $chanel): static
    {
        if ($this->chanels->removeElement($chanel)) {
            $chanel->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Association>
     */
    public function getAssociations(): Collection
    {
        return $this->associations;
    }

    public function addAssociation(Association $association): static
    {
        if (!$this->associations->contains($association)) {
            $this->associations->add($association);
            $association->setUser($this);
        }

        return $this;
    }

    public function removeAssociation(Association $association): static
    {
        if ($this->associations->removeElement($association)) {
            // set the owning side to null (unless already changed)
            if ($association->getUser() === $this) {
                $association->setUser(null);
            }
        }

        return $this;
    }

}
