<?php

namespace App\Entity;

use App\Repository\EtatDesLieuxRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatDesLieuxRepository::class)
 */
class EtatDesLieux
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nbPieces;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $surface;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Types::class, inversedBy="etatDesLieuxes")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Villes::class, inversedBy="etatDesLieuxes")
     */
    private $villes;

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

    public function getNbPieces(): ?string
    {
        return $this->nbPieces;
    }

    public function setNbPieces(?string $nbPieces): self
    {
        $this->nbPieces = $nbPieces;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(?string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getType(): ?Types
    {
        return $this->type;
    }

    public function setType(?Types $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getVilles(): ?Villes
    {
        return $this->villes;
    }

    public function setVilles(?Villes $villes): self
    {
        $this->villes = $villes;

        return $this;
    }
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'titre' => $this->getTitre(),
            'type' => $this->getType(),
            'villes' => $this->getVilles(),
            'nbPieces' => $this->getNbPieces(),
            'surface' => $this->getSurface(),
            'photo' => $this->getPhoto(),
        ];
    }
}
