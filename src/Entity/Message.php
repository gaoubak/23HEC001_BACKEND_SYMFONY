<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="message")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_message"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Groups({"get_message"})
     */
    private $user;

    /**
     * @ORM\Column(type="text")
     * @Groups({"get_message"})
    */
    private $userText;

    /**
     * @ORM\ManyToOne(targetEntity="Chanel")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id")
     * @Groups({"get_message"})
     */
    private $channel;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get_message"})
    */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserText(): ?string
    {
        return $this->userText;
    }

    public function setUserText(string $userText): self
    {
        $this->userText = $userText;

        return $this;
    }

    public function getChannel(): ?Chanel
    {
        return $this->channel;
    }

    public function setChannel(?Chanel $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
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

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


}


