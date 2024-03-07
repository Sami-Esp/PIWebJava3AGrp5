<?php

namespace App\Entity;

use App\Repository\SponsorsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SponsorsRepository::class)]
class Sponsors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"Le nom est requis")]
    private ?string $nom = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Le montant est requis")]
    private ?float $montant = null;

    #[ORM\ManyToOne(inversedBy: 'Sponsorsl')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenements $Evenementd = null;

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

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getEvenementd(): ?Evenements
    {
        return $this->Evenementd;
    }

    public function setEvenementd(?Evenements $Evenementd): static
    {
        $this->Evenementd = $Evenementd;

        return $this;
    }
}
