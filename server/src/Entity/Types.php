<?php

namespace App\Entity;

use App\Repository\TypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypesRepository::class)
 */
class Types
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=EtatDesLieux::class, mappedBy="type")
     */
    private $etatDesLieuxes;

    public function __construct()
    {
        $this->etatDesLieuxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|EtatDesLieux[]
     */
    public function getEtatDesLieuxes(): Collection
    {
        return $this->etatDesLieuxes;
    }

    public function addEtatDesLieux(EtatDesLieux $etatDesLieux): self
    {
        if (!$this->etatDesLieuxes->contains($etatDesLieux)) {
            $this->etatDesLieuxes[] = $etatDesLieux;
            $etatDesLieux->setType($this);
        }

        return $this;
    }

    public function removeEtatDesLieux(EtatDesLieux $etatDesLieux): self
    {
        if ($this->etatDesLieuxes->removeElement($etatDesLieux)) {
            // set the owning side to null (unless already changed)
            if ($etatDesLieux->getType() === $this) {
                $etatDesLieux->setType(null);
            }
        }

        return $this;
    }
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'libelle' => $this->getLibelle()
        ];
    }
}