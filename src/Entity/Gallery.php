<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GalleryRepository")
 */
class Gallery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(
     *     maxSize = "2000k",
     *     maxSizeMessage = "Veuillez télécharger une image inferieure a 2 Mo.",
     *     mimeTypes = {"image/*"},
     *     mimeTypesMessage = "Télécharger une photo en jpg ou png"
     * )
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spectacles", inversedBy="galleries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spectacle;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getSpectacle(): ?Spectacles
    {
        return $this->spectacle;
    }

    public function setSpectacle(?Spectacles $spectacle): self
    {
        $this->spectacle = $spectacle;

        return $this;
    }

}
