<?php

namespace App\Entity;

use App\Entity\Contrat;
use App\Entity\Societe;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\ManyToOne(targetEntity: Contrat::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $contrat;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'text')]
    private $profil;

    #[ORM\Column(type: 'float')]
    private $salaire;

    #[ORM\Column(type: 'string', length: 255)]
    private $ville;

    #[ORM\ManyToOne(targetEntity: Societe::class, inversedBy: 'annonces')]
    private $societe;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Postulation::class)]
    private $postulations;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: Domaine::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $domaine;

    #[ORM\ManyToOne(targetEntity: Departement::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $departement;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Candidature::class)]
    private $candidatures;


    public function __construct()
    {
        $this->postulations = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->competence = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

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

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(string $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSociete(): ?Societe
    {
        return $this->societe;
    }

    public function setSociete(?Societe $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * @return Collection<int, Postulation>
     */
    public function getPostulations(): Collection
    {
        return $this->postulations;
    }

    public function addPostulation(Postulation $postulation): self
    {
        if (!$this->postulations->contains($postulation)) {
            $this->postulations[] = $postulation;
            $postulation->setAnnonce($this);
        }

        return $this;
    }

    public function removePostulation(Postulation $postulation): self
    {
        if ($this->postulations->removeElement($postulation)) {
            // set the owning side to null (unless already changed)
            if ($postulation->getAnnonce() === $this) {
                $postulation->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDomaine(): ?Domaine
    {
        return $this->domaine;
    }

    public function setDomaine(?Domaine $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }


    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setAnnonce($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getAnnonce() === $this) {
                $candidature->setAnnonce(null);
            }
        }

        return $this;
    }
}
