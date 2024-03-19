<?php

namespace App\Entity;

use App\Repository\DemandeServiceRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeServiceRepository::class)]
class DemandeService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\Length(
        min :3,
        max: 30 ,
        minMessage: "Le nom doit contenir au moins 3 caractères",
        maxMessage: "Le nom doit contenir au plus 30 caractères",
    )]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    #[Assert\Length(
        min :3,
        max: 30 ,
        minMessage: "Le prenom doit contenir au moins 3 caractères",
        maxMessage: "Le prenom doit contenir au plus 30 caractères",
    )]
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;
    #[Assert\NotBlank(message:"L'email ne peut pas être vide.")]
    #[Assert\Email(
        message:"L'adresse email '{{ value }}' n'est pas une adresse email valide."
    )]
    #[ORM\Column(length: 255)]
    private ?string $email = null;
    #[Assert\NotBlank(message: 'Veuillez saisir votre numéro de téléphone')]
    #[Assert\Length(min: 8, max: 8, exactMessage: 'Le numéro de téléphone doit contenir 8 chiffres')]
    #[Assert\Regex(pattern: '/^(2|5|9)[0-9]{7}$/', message: 'Le numéro de téléphone doit commencer par 2 ou 5 ou 9 et contenir 8 chiffres')]
    #[ORM\Column]
    private ?int $telephone = null;
    #[Assert\EqualTo('today',message: 'Veuillez saisir la date')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDemande = null;

    #[ORM\ManyToOne(inversedBy: 'demandeservice')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

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

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeInterface $dateDemande): static
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }
}
