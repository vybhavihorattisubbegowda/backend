<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pallets;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $weight;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $company_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPallets(): ?int
    {
        return $this->pallets;
    }

    public function setPallets(?int $pallets): self
    {
        $this->pallets = $pallets;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCompanyId(): ?Company
    {
        return $this->company_id;
    }

    public function setCompanyId(?Company $company_id): self
    {
        $this->company_id = $company_id;

        return $this;
    }
}
