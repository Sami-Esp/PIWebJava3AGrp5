<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[Broadcast]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contenue = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $id_utilisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_en_jour = null;

    #[ORM\OneToOne(mappedBy: 'id_reclamation', cascade: ['persist', 'remove'])]
    private ?Reponse $reponse = null;

    #[ORM\OneToOne(mappedBy: 'id_reclamation', cascade: ['persist', 'remove'])]
    private ?Reponse $no = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(string $contenue): static
    {
        $this->contenue = $contenue;

        return $this;
    }

    public function getIdUtilisateur(): ?string
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(string $id_utilisateur): static
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateEnJour(): ?\DateTimeInterface
    {
        return $this->date_en_jour;
    }

    public function setDateEnJour(\DateTimeInterface $date_en_jour): static
    {
        $this->date_en_jour = $date_en_jour;

        return $this;
    }

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(Reponse $reponse): static
    {
        // set the owning side of the relation if necessary
        if ($reponse->getIdReclamation() !== $this) {
            $reponse->setIdReclamation($this);
        }

        $this->reponse = $reponse;

        return $this;
    }

    public function getNo(): ?Reponse
    {
        return $this->no;
    }

    public function setNo(Reponse $no): static
    {
        // set the owning side of the relation if necessary
        if ($no->getIdReclamation() !== $this) {
            $no->setIdReclamation($this);
        }

        $this->no = $no;

        return $this;
    }
    public function __toString() { return strval($this->id); }

}
