<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttendanceRepository")
 */
class Attendance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bill", inversedBy="attendances")
     * @ORM\JoinColumn
     */
    private $bill;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getBill() {
        return $this->bill;
    }

    /**
     * @param mixed $bill
     */
    public function setBill($bill): void {
        $this->bill = $bill;
    }
}
