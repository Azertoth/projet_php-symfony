<?php

namespace App\Entity;

use App\Repository\SortiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortiesRepository::class)
 */
class Sorties
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nomSortie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateHeureDebut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLimiteInscription;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbInscriptionsMax;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $infosSortie;

    /**
     * @ORM\Column(type="string")
     */
    private $etatSortir;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $urlPhoto;

    /**
     * @ORM\ManyToOne(targetEntity=Etats::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=true)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Lieux::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieux;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    /**
     * @ORM\ManyToOne(targetEntity=Particpant::class, inversedBy="organisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateur;

    /**
     * @ORM\OneToMany(targetEntity=Inscriptions::class, mappedBy="sortie")
     */
    private $inscriptions;

    



    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSortie(): ?string
    {
        return $this->nomSortie;
    }

    public function setNomSortie(string $nomSortie): self
    {
        $this->nomSortie = $nomSortie;

        return $this;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): self
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getEtatSortir(): ?string
    {
        return $this->etatSortir;
    }

    public function setEtatSortir(?string $etatSortir): self
    {
        $this->etatSortir = $etatSortir;

        return $this;
    }

    public function getUrlPhoto(): ?string
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto(?string $urlPhoto): self
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }

    public function getEtat(): ?Etats
    {
        return $this->etat;
    }

    public function setEtat(?Etats $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLieux(): ?Lieux
    {
        return $this->lieux;
    }

    public function setLieux(?Lieux $lieux): self
    {
        $this->lieux = $lieux;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getOrganisateur(): ?Particpant
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Particpant $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    /**
     * @return Collection|Inscriptions[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscriptions $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setSortie($this);
        }

        return $this;
    }

    public function removeInscription(Inscriptions $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getSortie() === $this) {
                $inscription->setSortie(null);
            }
        }

        return $this;
    }


}
