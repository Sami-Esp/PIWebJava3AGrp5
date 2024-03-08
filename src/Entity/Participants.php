<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ParticipantsRepository::class)]
class Participants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"Nom est requis")]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"Prenom est requis")]
    private ?string $prenom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message:"L'email est requis")]
    #[Assert\Email(message:"L email '{{ value}}' n'est pas valide")]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Le Telephone est requis")]
    #[Assert\Length(min:8,minMessage:"Pas assez de chiffres pour un téléphone (minimum {{ limit }} chiffres)")]
    #[Assert\Length(max:12,maxMessage:"Trop de chiffres pour un téléphone (maximum {{ limit }} chiffres) ")]
    private ?int $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'Participantsl')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenements $Evenementp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEvenementp(): ?Evenements
    {
        return $this->Evenementp;
    }

    public function setEvenementp(?Evenements $Evenementp): static
    {
        $this->Evenementp = $Evenementp;

        return $this;
    }
}
