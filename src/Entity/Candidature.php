<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private $annonce;

    #[ORM\ManyToOne(targetEntity: Candidat::class, inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private $candidat;

    #[ORM\Column(type: 'text', nullable: true)]
    private $message;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $consulte;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $retenu;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function isConsulte(): ?bool
    {
        return $this->consulte;
    }

    public function setConsulte(?bool $consulte): self
    {
        $this->consulte = $consulte;

        return $this;
    }

    public function isRetenu(): ?bool
    {
        return $this->retenu;
    }

    public function setRetenu(?bool $retenu): self
    {
        $this->retenu = $retenu;

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
}
