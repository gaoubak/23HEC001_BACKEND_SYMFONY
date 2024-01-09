<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="chanel")
 */
class Chanel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_chanel", "get_my_chanel", "get_user", "get_message","get_follower"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="chanel_user",
     *      joinColumns={@ORM\JoinColumn(name="chanel_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     * @Groups({"get_chanel", "get_my_chanel"})
     */
    private $users;

    /**
     * @ORM\Column(type="text")
     * @Groups({"get_chanel", "get_my_chanel", "get_user", "get_message","get_follower"})
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="Follower", mappedBy="chanel")
     */
    private $followers;

    /**
     * @ORM\OneToMany(targetEntity="Association", mappedBy="chanel")
     */
    private $associations;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"get_chanel", "get_my_chanel", "get_user", "get_message","get_follower"})
     */
    private $chanelPhoto;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }
    

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
    public function getUsers(): Collection
    {
        return $this->users;
    }
   
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addChanel($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|Follower[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function removeUserFollower(Follower $follower): self
    {
        $this->followers->removeElement($follower);

        return $this;
    }

    /**
     * @return Collection|Association[]
     */
    public function getAssociations(): Collection
    {
        return $this->associations;
    }

    public function addAssociation(Association $association): self
    {
        if (!$this->associations->contains($association)) {
            $this->associations[] = $association;
            $association->setChanel($this);
        }

        return $this;
    }

    public function removeAssociation(Association $association): self
    {
        $this->associations->removeElement($association);

        return $this;
    }

    public function getChanelPhoto(): ?string
    {
        return $this->chanelPhoto;
    }

    public function setChanelPhoto(?string $chanelPhoto): self
    {
        $this->chanelPhoto = $chanelPhoto;

        return $this;
    }
}
