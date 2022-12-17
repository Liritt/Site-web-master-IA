<?php

namespace App\Entity;

use App\Repository\CandidacyTERRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidacyTERRepository::class)]
class CandidacyTER
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'candidacyTERs')]
    private ?User $admis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAdmis(): ?User
    {
        return $this->admis;
    }

    public function setAdmis(?User $admis): self
    {
        $this->admis = $admis;

        return $this;
    }
}
