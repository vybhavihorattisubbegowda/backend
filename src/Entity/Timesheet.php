<?php

namespace App\Entity;

use App\Repository\TimesheetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TimesheetRepository::class)
 */
class Timesheet
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
    private $check_in;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $check_out;

    /**
     * @ORM\ManyToOne(targetEntity=Attendence::class, inversedBy="timesheets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $atendance_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckIn(): ?string
    {
        return $this->check_in;
    }

    public function setCheckIn(?string $check_in): self
    {
        $this->check_in = $check_in;

        return $this;
    }

    public function getCheckOut(): ?string
    {
        return $this->check_out;
    }

    public function setCheckOut(?string $check_out): self
    {
        $this->check_out = $check_out;

        return $this;
    }

    public function getAtendanceId(): ?Attendence
    {
        return $this->atendance_id;
    }

    public function setAtendanceId(?Attendence $atendance_id): self
    {
        $this->atendance_id = $atendance_id;

        return $this;
    }
}
