<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryRepository::class)
 */
class Delivery
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
    private $date;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $delivery_nr;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pallets;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $storage_area;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="deliveries")
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

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getDeliveryNr(): ?string
    {
        return $this->delivery_nr;
    }

    public function setDeliveryNr(?string $delivery_nr): self
    {
        $this->delivery_nr = $delivery_nr;

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

    public function getStorageArea(): ?int
    {
        return $this->storage_area;
    }

    public function setStorageArea(?int $storage_area): self
    {
        $this->storage_area = $storage_area;

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
