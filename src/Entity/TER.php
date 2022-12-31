<?php

namespace App\Entity;

use App\Repository\TERRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TERRepository::class)]
class TER
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $degree = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'TERs')]
    private ?Teacher $teacher = null;

    #[ORM\OneToMany(mappedBy: 'TER', targetEntity: CandidacyTER::class)]
    private Collection $candidacyTERs;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToOne(mappedBy: 'assignedTER', cascade: ['persist', 'remove'])]
    private ?Student $selectedStudent = null;

    public function __construct()
    {
        $this->candidacyTERs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDegree(): ?int
    {
        return $this->degree;
    }

    public function setDegree(int $degree): self
    {
        $this->degree = $degree;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * @return Collection<int, CandidacyTER>
     */
    public function getCandidacyTERs(): Collection
    {
        return $this->candidacyTERs;
    }

    public function addCandidacyTER(CandidacyTER $candidacyTER): self
    {
        if (!$this->candidacyTERs->contains($candidacyTER)) {
            $this->candidacyTERs->add($candidacyTER);
            $candidacyTER->setTER($this);
        }

        return $this;
    }

    public function removeCandidacyTER(CandidacyTER $candidacyTER): self
    {
        if ($this->candidacyTERs->removeElement($candidacyTER)) {
            // set the owning side to null (unless already changed)
            if ($candidacyTER->getTER() === $this) {
                $candidacyTER->setTER(null);
            }
        }

        return $this;
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

    public function getSelectedStudent(): ?Student
    {
        return $this->selectedStudent;
    }

    public function setSelectedStudent(?Student $selectedStudent): self
    {
        // unset the owning side of the relation if necessary
        if ($selectedStudent === null && $this->selectedStudent !== null) {
            $this->selectedStudent->setAssignedTER(null);
        }

        // set the owning side of the relation if necessary
        if ($selectedStudent !== null && $selectedStudent->getAssignedTER() !== $this) {
            $selectedStudent->setAssignedTER($this);
        }

        $this->selectedStudent = $selectedStudent;

        return $this;
    }
}
