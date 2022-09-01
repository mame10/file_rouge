<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["user" => "User", "client" => "Client", "livreur" => "Livreur", "gestionnaire" => "Gestionnaire"])]


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "method" => "get",
            'status' => Response::HTTP_CREATED,
            'normalization_context' => ['groups' => ['user:read:all']]
        ]
    ],
    itemOperations: ["put",
     "get" => [
        "method" => "get",
        'normalization_context' => ['groups' => ['user:read:all']]
     ]
     ]
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:all", "user:read:simple", "write",'user:write','commande','liv','livraison'])]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["burger:read:all", "user:read:simple", "user:read:all", "write",'user:write','liv'])]
    protected $login;

    #[ORM\Column(type: 'json')]
    #[Groups(["user:read:all"])]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(["user:read:simple",'write'])]
    protected $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["user:read:simple", "user:read:all", "write",'user:write','liv','livraison'])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["user:read:simple", "user:read:all", "write",'user:write','liv','livraison'])]
    protected $prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["user:read:all", "write"])]
    protected $token;

    #[SerializedName("password")]
    #[Groups(["write",'user:write','liv'])]
    protected $plainPassword;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(["write",'user:read:all'])]
    protected $expireAt;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Produit::class,cascade:['persist'])]
    private Collection $produits;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commande::class)]
    #[Groups('write','user:read:all')]
    #[ApiSubresource()]
    private Collection $commandes;


    public function __construct()
    {
       $this->expireAt = new \DateTime();
       $this->commandes = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_VISITEUR';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {

        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getExpireAt(): ?\DateTime
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTime $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setUser($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getUser() === $this) {
                $produit->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }


   
}
