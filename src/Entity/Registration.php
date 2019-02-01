<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegistrationRepository")
 */
class Registration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activities", inversedBy="registrations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    public function __construct()
    {
        $this->validated = 'non';
    }

    /**
     * @return mixed
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * @param mixed $validated
     */
    public function setValidated($validated): void
    {
        $this->validated = $validated;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $validated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getActivity(): ?Activities
    {
        return $this->activity;
    }

    public function setActivity(?Activities $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

}
