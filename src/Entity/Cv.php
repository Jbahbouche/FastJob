<?php

namespace App\Entity;

use App\Entity\Atouts;
use App\Entity\Formation;
use App\Entity\Experience;
use App\Repository\CvRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CvRepository::class)]
class Cv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'cv', targetEntity: Formation::class)]
    private $formations;

    #[ORM\OneToMany(mappedBy: 'cv', targetEntity: Experience::class)]
    private $experience;

    #[ORM\OneToMany(mappedBy: 'cv', targetEntity: Atouts::class)]
    private $atouts;

    #[ORM\Column(type: 'text', nullable: true)]
    private $interets;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->experience = new ArrayCollection();
        $this->atouts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setCv($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCv() === $this) {
                $formation->setCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, experience>
     */
    public function getExperience(): Collection
    {
        return $this->experience;
    }

    public function addExperience(Experience $experience): self
    {
        if (!$this->experience->contains($experience)) {
            $this->experience[] = $experience;
            $experience->setCv($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): self
    {
        if ($this->experience->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getCv() === $this) {
                $experience->setCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, atouts>
     */
    public function getAtouts(): Collection
    {
        return $this->atouts;
    }

    public function addAtout(Atouts $atout): self
    {
        if (!$this->atouts->contains($atout)) {
            $this->atouts[] = $atout;
            $atout->setCv($this);
        }

        return $this;
    }

    public function removeAtout(Atouts $atout): self
    {
        if ($this->atouts->removeElement($atout)) {
            // set the owning side to null (unless already changed)
            if ($atout->getCv() === $this) {
                $atout->setCv(null);
            }
        }

        return $this;
    }

    public function getInterets(): ?string
    {
        return $this->interets;
    }

    public function setInterets(?string $interets): self
    {
        $this->interets = $interets;

        return $this;
    }
}
