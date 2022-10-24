<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $nom;

    #[ORM\ManyToOne(targetEntity: domaine::class, inversedBy: 'competences')]
    #[ORM\JoinColumn(nullable: false)]
    private $domaine;

    #[ORM\ManyToMany(targetEntity: Candidat::class, mappedBy: 'competences')]
    private $candidat;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->candidat = new ArrayCollection();
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

    public function getDomaine(): ?domaine
    {
        return $this->domaine;
    }

    public function setDomaine(?domaine $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function __toString(){
        return $this->nom;
    }

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidat(): Collection
    {
        return $this->candidat;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidat->contains($candidat)) {
            $this->candidat[] = $candidat;
            $candidat->addCompetence($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidat->removeElement($candidat)) {
            $candidat->removeCompetence($this);
        }

        return $this;
    }

}
