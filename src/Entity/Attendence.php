<?php

namespace App\Entity;

use App\Repository\AttendenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string")
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

    /**
     * @ORM\OneToMany(targetEntity=Timesheet::class, mappedBy="atendance_id", orphanRemoval=true)
     */
    private $timesheets;

    public function __construct()
    {
        $this->timesheets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
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

    /**
     * @return Collection|Timesheet[]
     */
    public function getTimesheets(): Collection
    {
        return $this->timesheets;
    }

    public function addTimesheet(Timesheet $timesheet): self
    {
        if (!$this->timesheets->contains($timesheet)) {
            $this->timesheets[] = $timesheet;
            $timesheet->setAtendanceId($this);
        }

        return $this;
    }

    public function removeTimesheet(Timesheet $timesheet): self
    {
        if ($this->timesheets->removeElement($timesheet)) {
            // set the owning side to null (unless already changed)
            if ($timesheet->getAtendanceId() === $this) {
                $timesheet->setAtendanceId(null);
            }
        }

        return $this;
    }
}
