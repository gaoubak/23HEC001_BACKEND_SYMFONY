<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="association", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"user_id", "chanel_id"})
 * })
 */
class Association
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"association"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"association"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Chanel")
     * @ORM\JoinColumn(name="chanel_id", referencedColumnName="id")
     * @Groups({"association"})
     */
    private $chanel;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $userId): self
    {
        $this->user = $userId;

        return $this;
    }

    public function getChanel(): ?Chanel
    {
        return $this->chanel;
    }

    public function setChanel(?Chanel $chanel): self
    {
        $this->chanel = $chanel;

        return $this;
    }

}
