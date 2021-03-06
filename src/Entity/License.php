<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LicenseRepository")
 * @ORM\Table(name="license")
 */
class License
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
	 * @Assert\Date
	 * @var string A "Y-m-d" formatted value
     */
    private $date_obtention;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Candidat", mappedBy="licenses", cascade={"persist"})
     * @ORM\JoinTable(name="license_candidat")
     */
    private $candidat;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
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

    public function getDateObtention(): string
    {
        return $this->date_obtention;
    }

    public function setDateObtention(DateTimeInterface $date_obtention): self
    {
        $this->date_obtention = $date_obtention;

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
}
