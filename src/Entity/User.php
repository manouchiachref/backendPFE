<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"password"}, message="There is already an account with this password")
 */
class User implements UserInterface
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    
    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdDate;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Projet::class, mappedBy="user")
     */
    private $Projects;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $matricule_fiscal;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $solde;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;

    public function __construct()
    {
        $this->Projects = new ArrayCollection();
    }
    
    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    { $this->id = $id; }
    
    /**
     * @return mixed
     */
    public function getName()
    { return $this->name; }

    /**
     * @param mixed $name
     */
    public function setName($name)
    { $this->name = $name; }
    
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER


        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getCreatedDate()
    { return $this->createdDate; }

    /**
     * @param mixed $createdDate
     */
    public function setCreatedDate($createdDate)
    { $this->createdDate = $createdDate; }
    
    /**
     * @return mixed
     */
    public function getStatus()
    { return $this->status; }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    { $this->status = $status; }


    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjects(): Collection
    {
        return $this->Projects;
    }

    public function addProject(Projet $project): self
    {
        if (!$this->Projects->contains($project)) {
            $this->Projects[] = $project;
            $project->setUser($this);
        }

        return $this;
    }

    public function removeProject(Projet $project): self
    {
        if ($this->Projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getUser() === $this) {
                $project->setUser(null);
            }
        }

        return $this;
    }

    public function getMetier(): ?string
    {
        return $this->metier;
    }

    public function setMetier(?string $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(?string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getMatriculeFiscal(): ?string
    {
        return $this->matricule_fiscal;
    }

    public function setMatriculeFiscal(?string $matricule_fiscal): self
    {
        $this->matricule_fiscal = $matricule_fiscal;

        return $this;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(?float $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }
}