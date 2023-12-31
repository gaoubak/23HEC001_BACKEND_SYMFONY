<?php 

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Entity\Chanel;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity()
 * @ORM\Table(name="follower")
 */
class Follower
{
   
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_follower", "get_chanel"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"get_follower", "get_chanel"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="follower_id", referencedColumnName="id")
     * @Groups({"get_follower", "get_chanel"})
     */
    private $follower;

     /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"get_follower", "get_chanel"})
     */
    private  $chanel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFollower(): ?User
    {
        return $this->follower;
    }

    public function setFollower(?User $follower): self
    {
        $this->follower = $follower;

        return $this;
    }

    public function getChanel(): ?User
    {
        return $this->chanel;
    }

    public function setChanel(?User $chanel): self
    {
        $this->chanel = $chanel;

        return $this;
    }

    public function createChanel(): ?Chanel
    {
        $chanel = new Chanel();
        $chanel->setNom($this->getFollower()->getUsername());
        return $chanel;
    }
}
