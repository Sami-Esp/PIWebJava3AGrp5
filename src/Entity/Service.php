<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Veuillez saisir votre nom')]
    #[Assert\Length(
        min: 3,
        max: 40,
        minMessage: "Le nom doit contenir au moins 3 caractères",
        maxMessage: "Le nom doit contenir au plus 40 caractères",
    )]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Assert\NotBlank(message: "La catégorie ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "La catégorie ne peut pas dépasser 18 caractères."
    )]
    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[Assert\NotBlank(message: "La description ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "La description ne peut pas dépasser 255 caractères."
    )]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $dureeService = null;

    #[Assert\NotBlank(message: "La disponibilité du service ne peut pas être vide")]
    #[Assert\Length(
        max: 255,
        maxMessage: "La disponibilité du service ne peut pas dépasser 255 caractères."
    )]
    #[ORM\Column(length: 255)]
    private ?string $disponibiliteService = null;

    #[ORM\OneToMany(targetEntity: DemandeService::class, mappedBy: 'service')]
    private Collection $demandeservice;

   



    public function __construct()
    {
        $this->demandeservice = new ArrayCollection();
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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDureeService(): ?string
    {
        return $this->dureeService;
    }

    public function setDureeService(string $dureeService): static
    {
        $this->dureeService = $dureeService;

        return $this;
    }

    public function getDisponibiliteService(): ?string
    {
        return $this->disponibiliteService;
    }

    public function setDisponibiliteService(string $disponibiliteService): static
    {
        $this->disponibiliteService = $disponibiliteService;

        return $this;
    }

   
    /**
     * @return Collection<int, DemandeService>
     */
    public function getDemandeservice(): Collection
    {
        return $this->demandeservice;
    }

    public function addDemandeservice(DemandeService $demandeservice): static
    {
        if (!$this->demandeservice->contains($demandeservice)) {
            $this->demandeservice->add($demandeservice);
            $demandeservice->setService($this);
        }

        return $this;
    }

    public function removeDemandeservice(DemandeService $demandeservice): static
    {
        if ($this->demandeservice->removeElement($demandeservice)) {
            // set the owning side to null (unless already changed)
            if ($demandeservice->getService() === $this) {
                $demandeservice->setService(null);
            }
        }

        return $this;
    }

   
   


}
