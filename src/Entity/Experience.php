<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $moisDeb;

    #[ORM\Column(type: 'integer')]
    private $anneeDeb;

    #[ORM\Column(type: 'string', length: 255)]
    private $moisFin;

    #[ORM\Column(type: 'integer')]
    private $anneeFin;

    #[ORM\Column(type: 'string', length: 255)]
    private $poste;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lieu;

    #[ORM\Column(type: 'text', nullable: true)]
    private $missions;

    #[ORM\ManyToOne(targetEntity: Cv::class, inversedBy: 'experience')]
    private $cv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoisDeb(): ?string
    {
        return $this->moisDeb;
    }

    public function setMoisDeb(string $moisDeb): self
    {
        $this->moisDeb = $moisDeb;

        return $this;
    }

    public function getAnneeDeb(): ?int
    {
        return $this->anneeDeb;
    }

    public function setAnneeDeb(int $anneeDeb): self
    {
        $this->anneeDeb = $anneeDeb;

        return $this;
    }

    public function getMoisFin(): ?string
    {
        return $this->moisFin;
    }

    public function setMoisFin(string $moisFin): self
    {
        $this->moisFin = $moisFin;

        return $this;
    }

    public function getAnneeFin(): ?int
    {
        return $this->anneeFin;
    }

    public function setAnneeFin(int $anneeFin): self
    {
        $this->anneeFin = $anneeFin;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getMissions(): ?string
    {
        return $this->missions;
    }

    public function setMissions(?string $missions): self
    {
        $this->missions = $missions;

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
}
