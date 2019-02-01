<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivitiesRepository")
 */
class Activities
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cours;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $day;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reservation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hour;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\File(
     *     maxSize = "2000k"
     * )
     *
     * @Assert\Image(
     *     allowPortrait = false
     * )
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Registration", mappedBy="activity", orphanRemoval=true)
     */
    private $registrations;

    public function __toString()
    {
        return $this->cours;
    }

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCours(): ?string
    {
        return $this->cours;
    }

    public function setCours(string $cours): self
    {
        $this->cours = $cours;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day): void
    {
        $this->day = $day;
    }


    public function getReservation(): ?string
    {
        return $this->reservation;
    }

    public function setReservation(?string $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }


    public function getHour(): ?string
    {
        return $this->hour;
    }

    public function setHour(string $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Registration[]
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): self
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations[] = $registration;
            $registration->setActivity($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): self
    {
        if ($this->registrations->contains($registration)) {
            $this->registrations->removeElement($registration);
            // set the owning side to null (unless already changed)
            if ($registration->getActivity() === $this) {
                $registration->setActivity(null);
            }
        }

        return $this;
    }

    public function getRegistrationsValidated()
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('validated', 'oui'))
        ;

        return $this->getRegistrations()->matching($criteria)->count();
    }
}
