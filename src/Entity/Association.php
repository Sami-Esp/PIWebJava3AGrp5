<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AssociationRepository::class)]
class Association
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotBlank(message: 'Veuillez saisir le nom  ')]
    #[Assert\Length(
        min :2,
        max: 40 ,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères",
        maxMessage: "Le nom doit contenir au plus {{ limit }} caractères",
    )]
   
    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    

    #[Assert\NotBlank(message: 'Veuillez saisir le numéro de téléphone')]
    #[Assert\Length(min: 8, max: 8, exactMessage: 'Le numéro de téléphone doit contenir 8 chiffres')]
    #[Assert\NotBlank(message:" le telephone doit etre non vide")]
    #[ORM\Column]
    private ?int $telephone = null;
    #[Assert\NotBlank(message: 'Email obligatoire')]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
        message: "L'adresse email '{{ value }}' n'est pas valide."
    )]
    #[ORM\Column(length: 255)]
    private ?string $email = null;
    #[Assert\NotBlank(message:" le lieu doit etre non vide")]
    #[ORM\Column(length: 255)]
    private ?string $lieu = null;
    #[Assert\Length( min : 1,max :13,minMessage:" Entrer  codePostal au mini de 1 caractere",maxMessage:"doit etre <=13" )]
    #[ORM\Column]
    private ?int $codePostal = null;
    #[Assert\NotBlank(message:" la description doit etre non vide")]
    #[ORM\Column(length: 300000)]
    private ?string $description = null;
    #[ORM\Column(length: 255,nullable:true)]
    private ?string $photo = null;

    #[ORM\OneToMany(targetEntity: Don::class, mappedBy: 'association')]
    private Collection $don;

    public function __construct()
    {
        $this->don = new ArrayCollection();

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

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): static
    {
        $this->codePostal = $codePostal;

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
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    
    /**
     * @return Collection<int, Don>
     */
    public function getDon(): Collection
    {
        return $this->don;
    }

    public function addDon(Don $don): static
    {
        if (!$this->don->contains($don)) {
            $this->don->add($don);
            $don->setAssociation($this);
        }

        return $this;
    }

    public function removeDon(Don $don): static
    {
        if ($this->don->removeElement($don)) {
            // set the owning side to null (unless already changed)
            if ($don->getAssociation() === $this) {
                $don->setAssociation(null);
            }
        }

        return $this;
    }
}
