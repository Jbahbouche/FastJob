<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Annonce;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SocieteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: SocieteRepository::class)]
class Societe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $representantNom;

    #[ORM\Column(type: 'string', length: 255)]
    private $representantPrenom;

    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $logo;

    #[ORM\OneToMany(mappedBy: 'societe', targetEntity: Annonce::class)]
    private $annonces;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $site;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToOne(mappedBy: 'societe', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    #[ORM\Column(type: 'text')]
    private $adresse;



    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRepresentantNom(): ?string
    {
        return $this->representantNom;
    }

    public function setRepresentantNom(string $representantNom): self
    {
        $this->representantNom = $representantNom;

        return $this;
    }

    public function getRepresentantPrenom(): ?string
    {
        return $this->representantPrenom;
    }

    public function setRepresentantPrenom(string $representantPrenom): self
    {
        $this->representantPrenom = $representantPrenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection<int, annonce>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setSociete($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getSociete() === $this) {
                $annonce->setSociete(null);
            }
        }

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setSociete(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getSociete() !== $this) {
            $user->setSociete($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
