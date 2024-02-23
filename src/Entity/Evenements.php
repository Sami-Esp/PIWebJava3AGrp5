<?php

namespace App\Entity;

use App\Repository\EvenementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: EvenementsRepository::class)]
class Evenements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"Nom est requis")]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"Date est requise")]
    #[Assert\Range(min:'now', minMessage:"On ne peut pas remonter dans le temps")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Lieu est requis")]
    private ?string $lieu = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Assert\NotBlank(message:"La description est requise")]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Sponsors::class, mappedBy: 'Evenementd', orphanRemoval: true)]
    private Collection $Sponsorsl;

    #[ORM\OneToMany(targetEntity: Participants::class, mappedBy: 'Evenementp', orphanRemoval: true)]
    private Collection $Participantsl;

    public function __construct()
    {
        $this->Sponsorsl = new ArrayCollection();
        $this->Participantsl = new ArrayCollection();
    }

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Sponsors>
     */
    public function getSponsorsl(): Collection
    {
        return $this->Sponsorsl;
    }

    public function addSponsorsl(Sponsors $sponsorsl): static
    {
        if (!$this->Sponsorsl->contains($sponsorsl)) {
            $this->Sponsorsl->add($sponsorsl);
            $sponsorsl->setEvenementd($this);
        }

        return $this;
    }

    public function removeSponsorsl(Sponsors $sponsorsl): static
    {
        if ($this->Sponsorsl->removeElement($sponsorsl)) {
            // set the owning side to null (unless already changed)
            if ($sponsorsl->getEvenementd() === $this) {
                $sponsorsl->setEvenementd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Participants>
     */
    public function getParticipantsl(): Collection
    {
        return $this->Participantsl;
    }

    public function addParticipantsl(Participants $participantsl): static
    {
        if (!$this->Participantsl->contains($participantsl)) {
            $this->Participantsl->add($participantsl);
            $participantsl->setEvenementp($this);
        }

        return $this;
    }

    public function removeParticipantsl(Participants $participantsl): static
    {
        if ($this->Participantsl->removeElement($participantsl)) {
            // set the owning side to null (unless already changed)
            if ($participantsl->getEvenementp() === $this) {
                $participantsl->setEvenementp(null);
            }
        }

        return $this;
    }
}
