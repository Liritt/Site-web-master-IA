<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student extends User
{
    #[ORM\Column(length: 20)]
    private ?string $lastname = null;

    #[ORM\Column(length: 20)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column]
    private ?int $degree = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?Internship $internship = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Candidacy::class, cascade: ['remove'])]
    private Collection $candidacies;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: CandidacyTER::class, cascade: ['remove'])]
    private Collection $candidacyTERs;

    #[ORM\OneToOne(inversedBy: 'selectedStudent', cascade: ['persist', 'remove'])]
    private ?TER $assignedTER = null;

    /*#[ORM\Column(type: Types::BLOB)]
    private $cv = null;

    #[ORM\Column(type: Types::BLOB)]
    private $certificate = null;*/

    public function __construct()
    {
        $this->candidacyTERs = new ArrayCollection();
        $this->candidacies = new ArrayCollection();
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
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

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getCertificate()
    {
        return $this->certificate;
    }

    public function setCertificate($certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function getInternship(): ?Internship
    {
        return $this->internship;
    }

    public function setInternship(?Internship $internship): self
    {
        $this->internship = $internship;

        return $this;
    }

    /**
     * @return Collection<int, Candidacy>
     */
    public function getCandidacies(): Collection
    {
        return $this->candidacies;
    }

    public function addCandidacy(Candidacy $candidacy): self
    {
        if (!$this->candidacies->contains($candidacy)) {
            $this->candidacies->add($candidacy);
            $candidacy->setStudent($this);
        }

        return $this;
    }

    public function removeCandidacy(Candidacy $candidacy): self
    {
        if ($this->candidacies->removeElement($candidacy)) {
            // set the owning side to null (unless already changed)
            if ($candidacy->getStudent() === $this) {
                $candidacy->setStudent(null);
            }
        }

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
            $candidacyTER->setStudent($this);
        }

        return $this;
    }

    public function removeCandidacyTER(CandidacyTER $candidacyTER): self
    {
        if ($this->candidacyTERs->removeElement($candidacyTER)) {
            // set the owning side to null (unless already changed)
            if ($candidacyTER->getStudent() === $this) {
                $candidacyTER->setStudent(null);
            }
        }

        return $this;
    }

    public function getAssignedTER(): ?TER
    {
        return $this->assignedTER;
    }

    public function setAssignedTER(?TER $assignedTER): self
    {
        $this->assignedTER = $assignedTER;

        return $this;
    }
}
