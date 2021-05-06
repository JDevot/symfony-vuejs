<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("post")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups("post")
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @Groups("post")
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="article")
     */
    private $user;

    /**
     * @Groups("post")
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="posts")
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'author' => [
                'email' => $this->getUser() ? $this->getUser()->getEmail() : null,
                'id' => $this->getUser() ? $this->getUser()->getId() : null
            ],
            'categorie' => [
                'label'  => $this->getCategorie() ? $this->getCategorie()->getLabel() : null,
                'id' => $this->getCategorie() ? $this->getCategorie()->getId() : null 
            ]
        ];
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategorie(): ?categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
