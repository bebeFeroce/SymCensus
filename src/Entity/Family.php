<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $headOfHousehold = null;

    #[ORM\OneToMany(mappedBy: 'family', targetEntity: Resident::class)]
    private Collection $familyMembers;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column(length: 50)]
    private ?string $country = null;

    #[ORM\Column]
    private ?string $contact = null;

    public function __construct()
    {
        $this->familyMembers = new ArrayCollection();
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

    public function getHeadOfHousehold(): ?string
    {
        return $this->headOfHousehold;
    }

    public function setHeadOfHousehold(string $headOfHousehold): self
    {
        $this->headOfHousehold = $headOfHousehold;

        return $this;
    }

    /**
     * @return Collection<int, Resident>
     */
    public function getFamilyMembers(): Collection
    {
        return $this->familyMembers;
    }

    public function addFamilyMember(Resident $familyMember): self
    {
        if (!$this->familyMembers->contains($familyMember)) {
            $this->familyMembers->add($familyMember);
            $familyMember->setFamily($this);
        }

        return $this;
    }

    public function removeFamilyMember(Resident $familyMember): self
    {
        if ($this->familyMembers->removeElement($familyMember)) {
            // set the owning side to null (unless already changed)
            if ($familyMember->getFamily() === $this) {
                $familyMember->setFamily(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
