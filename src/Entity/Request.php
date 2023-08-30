<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class Request
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="requests")
     */
    private $Pro;

    /**
     * @ORM\ManyToOne(targetEntity=Projet::class, inversedBy="requests")
     */
    private $Project;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(bool $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getPro(): ?User
    {
        return $this->Pro;
    }

    public function setPro(?User $Pro): self
    {
        $this->Pro = $Pro;

        return $this;
    }

    public function getProject(): ?Projet
    {
        return $this->Project;
    }

    public function setProject(?Projet $Project): self
    {
        $this->Project = $Project;

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
}
