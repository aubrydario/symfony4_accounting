<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttendanceRepository")
 * @ApiResource
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
     * @ApiSubresource
     */
    private $bill;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hour", inversedBy="attendances")
     * @ORM\JoinColumn
     * @ApiSubresource
     */
    private $hour;

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

    /**
     * @return mixed
     */
    public function getHour() {
        return $this->hour;
    }

    /**
     * @param mixed $hour
     */
    public function setHour($hour): void {
        $this->hour = $hour;
    }
}
