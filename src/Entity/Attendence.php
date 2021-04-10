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
     * @ORM\ManyToOne(targetEntity=Mitarbeiter::class, inversedBy="attendences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mitarbeiter_id;

    /**
     * @ORM\OneToMany(targetEntity=Timesheet::class, mappedBy="atendance_id", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $timesheets;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     */
    private $status;

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

    public function getMitarbeiterId(): ?Mitarbeiter
    {
        return $this->mitarbeiter_id;
    }
    //data type is class so, the input must contain all class attribute's values
    //all mandatory attribute'values must be sent and optional will be with ?
    //while creating reference(FK) objects must not be Nullable
    //these all attributes together called as object
    //the method itself will extract the mitarbeiter_id from object
    
    public function setMitarbeiterId(?Mitarbeiter $mitarbeiter_id): self
    {
        $this->mitarbeiter_id = $mitarbeiter_id;
        //function's return type self means it gives entire object of class Attendance(includes all attributes) 
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

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }
}
