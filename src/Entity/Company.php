<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $companyName = null;

    #[ORM\Column(length: 20)]
    private ?string $supervisorFirstname = null;

    #[ORM\Column(length: 20)]
    private ?string $supervisorLastname = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
