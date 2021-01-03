<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Address::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $address_id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $company_type;

    /**
     * @ORM\OneToMany(targetEntity=Delivery::class, mappedBy="company_id", orphanRemoval=true)
     */
    private $deliveries;

    public function __construct()
    {
        $this->deliveries = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddressId(): ?Address
    {
        return $this->address_id;
    }

    public function setAddressId(Address $address_id): self
    {
        $this->address_id = $address_id;

        return $this;
    }

    public function getCompanyType(): ?string
    {
        return $this->company_type;
    }

    public function setCompanyType(?string $company_type): self
    {
        $this->company_type = $company_type;

        return $this;
    }

    /**
     * @return Collection|Delivery[]
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): self
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries[] = $delivery;
            $delivery->setCompanyId($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): self
    {
        if ($this->deliveries->removeElement($delivery)) {
            // set the owning side to null (unless already changed)
            if ($delivery->getCompanyId() === $this) {
                $delivery->setCompanyId(null);
            }
        }

        return $this;
    }
}
