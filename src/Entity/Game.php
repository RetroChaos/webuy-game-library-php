<?php

  namespace App\Entity;

  use App\Repository\GameRepository;
  use Doctrine\Common\Collections\ArrayCollection;
  use Doctrine\Common\Collections\Collection;
  use Doctrine\DBAL\Types\Types;
  use Doctrine\ORM\Mapping as ORM;

  #[ORM\Entity(repositoryClass:GameRepository::class)]
  class Game {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length:255)]
    private ?string $name = null;

    #[ORM\Column(type:Types::DECIMAL, precision:5, scale:2)]
    private ?string $currentPrice = null;

    #[ORM\Column(length:8, nullable:true)]
    private ?string $ageRating = null;

    #[ORM\Column(length:255, nullable:true)]
    private ?string $boxArtUri = null;

    #[ORM\ManyToMany(targetEntity:PriceHistory::class, mappedBy:'game')]
    private Collection $priceHistory;

    #[ORM\ManyToOne(inversedBy:'games')]
    private ?Developer $developer = null;

    #[ORM\ManyToOne(inversedBy:'games')]
    #[ORM\JoinColumn(nullable:false)]
    private ?System $system = null;

    #[ORM\Column(length:255)]
    private ?string $cexId = null;

    public function __construct() {
      $this->priceHistory = new ArrayCollection();
    }

    public function getId(): ?int {
      return $this->id;
    }

    public function getName(): ?string {
      return $this->name;
    }

    public function setName(string $name): self {
      $this->name = $name;

      return $this;
    }

    public function getCurrentPrice(): ?string {
      return $this->currentPrice;
    }

    public function setCurrentPrice(string $currentPrice): self {
      $this->currentPrice = $currentPrice;

      return $this;
    }

    public function getAgeRating(): ?string {
      return $this->ageRating;
    }

    public function setAgeRating(?string $ageRating): self {
      $this->ageRating = $ageRating;

      return $this;
    }

    public function getBoxArtUri(): ?string {
      return $this->boxArtUri;
    }

    public function setBoxArtUri(?string $boxArtUri): self {
      $this->boxArtUri = $boxArtUri;

      return $this;
    }

    /**
     * @return Collection<int, PriceHistory>
     */
    public function getPriceHistory(): Collection {
      return $this->priceHistory;
    }

    public function addPriceHistory(PriceHistory $priceHistory): self {
      if(!$this->priceHistory->contains($priceHistory)) {
        $this->priceHistory->add($priceHistory);
        $priceHistory->addGame($this);
      }

      return $this;
    }

    public function removePriceHistory(PriceHistory $priceHistory): self {
      if($this->priceHistory->removeElement($priceHistory)) {
        $priceHistory->removeGame($this);
      }

      return $this;
    }

    public function getDeveloper(): ?Developer {
      return $this->developer;
    }

    public function setDeveloper(?Developer $developer): self {
      $this->developer = $developer;

      return $this;
    }

    public function getSystem(): ?System {
      return $this->system;
    }

    public function setSystem(?System $system): self {
      $this->system = $system;

      return $this;
    }

    public function getCexId(): ?string {
      return $this->cexId;
    }

    public function setCexId(string $cexId): self {
      $this->cexId = $cexId;

      return $this;
    }
  }
