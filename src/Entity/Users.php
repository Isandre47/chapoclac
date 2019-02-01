<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface
{
    public function json()
    {
        $result = json_decode($this->roles);
        return $result;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $userAdress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneHouse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phoneMobil;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var
     * @Assert\EqualTo(propertyPath="password" , message="mot de passe pas identique")
     */
    private $confirmPassword;

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contributions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $newsletters;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $insurance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numInsurance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numberCheck;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $doctorName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $doctorPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $doctorAdress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minorPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minorClass;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minorNameResponsable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Articles", mappedBy="author", fetch="EAGER")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="author", cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Spectacles", mappedBy="users")
     */
    private $spectacles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Messages", mappedBy="user")
     */
    private $messages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $validate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Registration", mappedBy="user", orphanRemoval=true, fetch="EAGER", cascade={"remove"})
     */
    private $registrations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureFun;

    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }


    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->spectacles = new ArrayCollection();

        // TODO: setter automatiquement la date et affecter un password random
        $this->createDate = new \DateTime('now');
        $this->setPassword(uniqid());
        $this->messages = new ArrayCollection();
        $this->registrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

// méthode pour récuper nom et prénom d'un utilisateur
    public function getFullname(): string
    {
        $fullName =  $this->getLastName(). ' '.$this->getFirstName();
        return $fullName;
    }

    public function getUserAdress(): ?string
    {
        return $this->userAdress;
    }

    public function setUserAdress(?string $userAdress): self
    {
        $this->userAdress = $userAdress;

        return $this;
    }

    public function getPhoneHouse(): ?string
    {
        return $this->phoneHouse;
    }

    public function setPhoneHouse(?string $phoneHouse): self
    {
        $this->phoneHouse = $phoneHouse;

        return $this;
    }

    public function getPhoneMobil(): ?string
    {
        return $this->phoneMobil;
    }

    public function setPhoneMobil(string $phoneMobil): self
    {
        $this->phoneMobil = $phoneMobil;

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

    public function getContributions(): ?string
    {
        return $this->contributions;
    }

    public function setContributions(?string $contributions): self
    {
        $this->contributions = $contributions;

        return $this;
    }

    public function getNewsletters(): ?string
    {
        return $this->newsletters;
    }

    public function setNewsletters(?string $newsletters): self
    {
        $this->newsletters = $newsletters;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(?\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getInsurance(): ?string
    {
        return $this->insurance;
    }

    public function setInsurance(?string $insurance): self
    {
        $this->insurance = $insurance;

        return $this;
    }

    public function getNumInsurance(): ?string
    {
        return $this->numInsurance;
    }

    public function setNumInsurance(?string $numInsurance): self
    {
        $this->numInsurance = $numInsurance;

        return $this;
    }

    public function getNumberCheck(): ?string
    {
        return $this->numberCheck;
    }

    public function setNumberCheck(?string $numberCheck): self
    {
        $this->numberCheck = $numberCheck;

        return $this;
    }

    public function getDoctorName(): ?string
    {
        return $this->doctorName;
    }

    public function setDoctorName(?string $doctorName): self
    {
        $this->doctorName = $doctorName;

        return $this;
    }

    public function getDoctorPhone(): ?string
    {
        return $this->doctorPhone;
    }

    public function setDoctorPhone(?string $doctorPhone): self
    {
        $this->doctorPhone = $doctorPhone;

        return $this;
    }

    public function getDoctorAdress(): ?string
    {
        return $this->doctorAdress;
    }

    public function setDoctorAdress(?string $doctorAdress): self
    {
        $this->doctorAdress = $doctorAdress;

        return $this;
    }

    public function getMinorPhone(): ?string
    {
        return $this->minorPhone;
    }

    public function setMinorPhone(?string $minorPhone): self
    {
        $this->minorPhone = $minorPhone;

        return $this;
    }

    public function getMinorClass(): ?string
    {
        return $this->minorClass;
    }

    public function setMinorClass(?string $minorClass): self
    {
        $this->minorClass = $minorClass;

        return $this;
    }

    public function getMinorNameResponsable(): ?string
    {
        return $this->minorNameResponsable;
    }

    public function setMinorNameResponsable(?string $minorNameResponsable): self
    {
        $this->minorNameResponsable = $minorNameResponsable;

        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Spectacles[]
     */
    public function getSpectacles(): Collection
    {
        return $this->spectacles;
    }

    public function addSpectacle(Spectacles $spectacle): self
    {
        if (!$this->spectacles->contains($spectacle)) {
            $this->spectacles[] = $spectacle;
            $spectacle->addUser($this);
        }

        return $this;
    }

    public function removeSpectacle(Spectacles $spectacle): self
    {
        if ($this->spectacles->contains($spectacle)) {
            $this->spectacles->removeElement($spectacle);
            $spectacle->removeUser($this);
        }

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Messages[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    public function getValidate(): ?string
    {
        return $this->validate;
    }

    public function setValidate(?string $validate): self
    {
        $this->validate = $validate;

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
            $registration->setUser($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): self
    {
        if ($this->registrations->contains($registration)) {
            $this->registrations->removeElement($registration);
            // set the owning side to null (unless already changed)
            if ($registration->getUser() === $this) {
                $registration->setUser(null);
            }
        }

        return $this;
    }

    public function getPictureFun()
    {
        return $this->pictureFun;
    }

    public function setPictureFun($pictureFun): self
    {
        $this->pictureFun = $pictureFun;

        return $this;
    }

    /**
     * @return string
     */
    public function getResetToken()
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

}
