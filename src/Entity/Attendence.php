<?php

namespace App\Entity;

use App\Repository\AttendenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttendenceRepository::class)
 */
class Attendence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Mitarbeiter::class, inversedBy="attendences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mitarbeiter_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMitarbeiterId(): ?Mitarbeiter
    {
        return $this->mitarbeiter_id;
    }

    public function setMitarbeiterId(?Mitarbeiter $mitarbeiter_id): self
    {
        $this->mitarbeiter_id = $mitarbeiter_id;

        return $this;
    }
}
