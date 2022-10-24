<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Postulation;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CandidatRepository::class)]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    private $naissance;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cvPDF;

    #[ORM\OneToOne(targetEntity: Cv::class, cascade: ['persist', 'remove'])]
    private $cv;

    #[ORM\Column(type: 'text', nullable: true)]
    private $presentation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $recherche;

    #[ORM\OneToOne(mappedBy: 'candidat', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    #[ORM\ManyToOne(targetEntity: Domaine::class, inversedBy: 'candidats')]
    private $domaine;

    #[ORM\ManyToMany(targetEntity: Competence::class, inversedBy: 'candidat')]
    private $competence;

    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: Candidature::class)]
    private $candidatures;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNaissance(): ?string
    {
        return $this->naissance;
    }

    public function setNaissance(string $naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function getCvPDF(): ?string
    {
        return $this->cvPDF;
    }

    public function setCvPDF(?string $cvPDF): self
    {
        $this->cvPDF = $cvPDF;

        return $this;
    }

    public function getCv(): ?Cv
    {
        return $this->cv;
    }

    public function setCv(?Cv $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getRecherche(): ?string
    {
        return $this->recherche;
    }

    public function setRecherche(?string $recherche): self
    {
        $this->recherche = $recherche;

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
            $this->user->setCandidat(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getCandidat() !== $this) {
            $user->setCandidat($this);
        }

        $this->user = $user;

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

    /**
     * @return Collection<int, Competence>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection<int, Competence>
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
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
            $candidature->setCandidat($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getCandidat() === $this) {
                $candidature->setCandidat(null);
            }
        }

        return $this;
    }
}
