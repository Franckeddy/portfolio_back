<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 * @ORM\Table(name="company")
 */
class Company
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $start_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $end_date;

    /**
     * @ORM\ManyToMany
     * (
     *  targetEntity="App\Entity\Candidat",
     *  mappedBy="companies",
     *  cascade={"persist"},
     *  fetch="EXTRA_LAZY"
     * )
     * @ORM\JoinTable(name="company_candidat")
     */
    private $candidat;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ActivityArea", inversedBy="company", cascade={"persist"})
     */
    private $activityAreas;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
        $this->activityAreas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidat(): Collection
    {
        return $this->candidat;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidat->contains($candidat)) {
            $this->candidat[] = $candidat;
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidat->contains($candidat)) {
            $this->candidat->removeElement($candidat);
        }

        return $this;
    }

    /**
     * @return Collection|ActivityArea[]
     */
    public function getActivityAreas(): Collection
    {
        return $this->activityAreas;
    }

    public function addActivityArea(ActivityArea $activityArea): self
    {
        if (!$this->activityAreas->contains($activityArea)) {
            $this->activityAreas[] = $activityArea;
            $activityArea->addCompany($this);
        }

        return $this;
    }

    public function removeActivityArea(ActivityArea $activityArea): self
    {
        if ($this->activityAreas->contains($activityArea)) {
            $this->activityAreas->removeElement($activityArea);
            $activityArea->removeCompany($this);
        }

        return $this;
    }
}
