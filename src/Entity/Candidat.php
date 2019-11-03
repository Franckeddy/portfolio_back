<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CandidatRepository")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_candidat_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 *
 * @Hateoas\Relation(
 *      "create",
 *      href = @Hateoas\Route(
 *          "app_candidat_create",
 *          absolute = true
 *      )
 * )
 * 
 * @ExclusionPolicy("all")
 * @ORM\Table(name="candidat")
 */
class Candidat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\NotBlank
	 * @Expose
	 * @Serializer\Since("1.0")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\NotBlank
	 * @Expose
	 * @Serializer\Since("1.0")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Expose @Expose
	 * @Serializer\Since("1.0")
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Expose @Expose
	 * @Serializer\Since("1.0")
     */
    private $town;

    /**
     * @ORM\Column(type="integer", nullable=true)
	 * @Expose @Expose
	 * @Serializer\Since("1.0")
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\NotBlank(groups={"Create"})
	 * @Assert\Email(
	 *     message = "The email '{{ value }}' is not a valid email.",
	 *     checkMX = true
	 * )
	 * @Expose
	 * @Serializer\Since("1.0")
     */
    private $email;

    /**
     * @ORM\Column(type="date", nullable=true)
	 * @Assert\Date
	 * @var string A "Y-m-d" formatted value
	 * @Expose
	 * @Serializer\Since("1.0")
     */
    private $date_of_birth;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Langue", mappedBy="candidat")
     *  @Expose
     */
    private $langues;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\License", mappedBy="candidat")
     *  @Expose
     */
    private $licenses;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\School", mappedBy="candidat")
     *  @Expose
     */
    private $schools;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Company", mappedBy="candidat")
     *  @Expose
     */
    private $companies;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Expose
	 * @Serializer\Since("2.0")
     */
    private $short_description;

    public function __construct()
    {
        $this->langues = new ArrayCollection();
        $this->licenses = new ArrayCollection();
        $this->schools = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateOfBirth(): ?DateTimeInterface
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(?DateTimeInterface $date_of_birth): self
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    /**
     * @return Collection|Langue[]
     */
    public function getLangues(): Collection
    {
        return $this->langues;
    }

    public function addLangue(Langue $langue): self
    {
        if (!$this->langues->contains($langue)) {
            $this->langues[] = $langue;
            $langue->addCandidat($this);
        }

        return $this;
    }

    public function removeLangue(Langue $langue): self
    {
        if ($this->langues->contains($langue)) {
            $this->langues->removeElement($langue);
            $langue->removeCandidat($this);
        }

        return $this;
    }

    /**
     * @return Collection|License[]
     */
    public function getLicenses(): Collection
    {
        return $this->licenses;
    }

    public function addLicense(License $license): self
    {
        if (!$this->licenses->contains($license)) {
            $this->licenses[] = $license;
            $license->addCandidat($this);
        }

        return $this;
    }

    public function removeLicense(License $license): self
    {
        if ($this->licenses->contains($license)) {
            $this->licenses->removeElement($license);
            $license->removeCandidat($this);
        }

        return $this;
    }

    /**
     * @return Collection|School[]
     */
    public function getSchools(): Collection
    {
        return $this->schools;
    }

    public function addSchool(School $school): self
    {
        if (!$this->schools->contains($school)) {
            $this->schools[] = $school;
            $school->addCandidat($this);
        }

        return $this;
    }

    public function removeSchool(School $school): self
    {
        if ($this->schools->contains($school)) {
            $this->schools->removeElement($school);
            $school->removeCandidat($this);
        }

        return $this;
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->addCandidat($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            $company->removeCandidat($this);
        }

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(?string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }
}
