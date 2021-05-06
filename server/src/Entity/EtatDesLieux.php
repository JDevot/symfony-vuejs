<?php

namespace App\Entity;
use App\Entity\Image;
use App\Repository\EtatDesLieuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity=Types::class, inversedBy="etatDesLieuxes")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Villes::class, inversedBy="etatDesLieuxes")
     */
    private $villes;

    /**
     * @ORM\OneToMany(targetEntity=image::class, mappedBy="etatDesLieux", orphanRemoval=true, cascade={"persist"})
     */
    private $photo;

    public function __construct()
    {
        $this->photo = new ArrayCollection();
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

    /**
     * @return Collection|image[]
     */
    public function getPhoto()
    {
        $data = [];
        foreach($this->photo as $photo){
            array_push($data, $photo->getPath());
        }
        return $data;
    }

    public function addPhoto(image $photo): self
    {
        if (!$this->photo->contains($photo)) {
            $this->photo[] = $photo;
            $photo->setEtatDesLieux($this);
        }

        return $this;
    }

    public function removePhoto(image $photo): self
    {
        if ($this->photo->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getEtatDesLieux() === $this) {
                $photo->setEtatDesLieux(null);
            }
        }

        return $this;
    }
}
