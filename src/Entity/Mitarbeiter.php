<?php

namespace App\Entity;

use App\Repository\MitarbeiterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MitarbeiterRepository::class)
 */
class Mitarbeiter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nachname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $vorname;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Attendence::class, mappedBy="mitarbeiter_id", orphanRemoval=true)
     */
    private $attendences;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passwort;

    public function __construct()
    {
        $this->attendences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(string $nachname): self
    {
        $this->nachname = $nachname;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Attendence[]
     */
    public function getAttendences(): Collection
    {
        return $this->attendences;
    }

    public function addAttendence(Attendence $attendence): self
    {
        if (!$this->attendences->contains($attendence)) {
            $this->attendences[] = $attendence;
            $attendence->setMitarbeiterId($this);
        }

        return $this;
    }

    public function removeAttendence(Attendence $attendence): self
    {
        if ($this->attendences->removeElement($attendence)) {
            // set the owning side to null (unless already changed)
            if ($attendence->getMitarbeiterId() === $this) {
                $attendence->setMitarbeiterId(null);
            }
        }

        return $this;
    }

    public function getPasswort(): ?string
    {
        return $this->passwort;
    }

    public function setPasswort(string $passwort): self
    {
        $this->passwort = $passwort;

        return $this;
    }
}
