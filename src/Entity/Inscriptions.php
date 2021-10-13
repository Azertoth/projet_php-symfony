<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionsRepository::class)
 */
class Inscriptions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\ManyToOne(targetEntity=Sorties::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $sortie;

    /**
     * @ORM\ManyToOne(targetEntity=Particpant::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $participants_no_participant;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getSortie(): ?Sorties
    {
        return $this->sortie;
    }

    public function setSortie(?Sorties $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }

    public function getParticipantsNoParticipant(): ?Particpant
    {
        return $this->participants_no_participant;
    }

    public function setParticipantsNoParticipant(?Particpant $participants_no_participant): self
    {
        $this->participants_no_participant = $participants_no_participant;

        return $this;
    }

    
}
