<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company extends User
{
    #[ORM\Column(length: 30)]
    private ?string $companyName = null;

    #[ORM\Column(length: 20)]
    private ?string $supervisorFirstname = null;

    #[ORM\Column(length: 20)]
    private ?string $supervisorLastname = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Internship::class)]
    private Collection $internships;

    public function __construct()
    {
        $this->internships = new ArrayCollection();
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getSupervisorFirstname(): ?string
    {
        return $this->supervisorFirstname;
    }

    public function setSupervisorFirstname(string $supervisorFirstname): self
    {
        $this->supervisorFirstname = $supervisorFirstname;

        return $this;
    }

    public function getSupervisorLastname(): ?string
    {
        return $this->supervisorLastname;
    }

    public function setSupervisorLastname(string $supervisorLastname): self
    {
        $this->supervisorLastname = $supervisorLastname;

        return $this;
    }

    /**
     * @return Collection<int, Internship>
     */
    public function getInternships(): Collection
    {
        return $this->internships;
    }

    public function addInternship(Internship $internship): self
    {
        if (!$this->internships->contains($internship)) {
            $this->internships->add($internship);
            $internship->setCompany($this);
        }

        return $this;
    }

    public function removeInternship(Internship $internship): self
    {
        if ($this->internships->removeElement($internship)) {
            // set the owning side to null (unless already changed)
            if ($internship->getCompany() === $this) {
                $internship->setCompany(null);
            }
        }

        return $this;
    }
}
