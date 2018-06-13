<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HourRepository")
 * @ApiResource
 */
class Hour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\Column(type="integer")
     */
    private $day;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Attendance", mappedBy="hour", fetch="EAGER")
     * @ApiSubresource
     */
    private $attendances;

    public function __construct()
    {
        $this->attendances = new ArrayCollection();
    }

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
     * @return mixed
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time): void {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getDay() {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day): void {
        $this->day = $day;
    }

    /**
     * @return Collection|Attendance[]
     */
    public function getAttendances() {
        return $this->attendances;
    }

    /**
     * @param mixed $attendances
     */
    public function setAttendances($attendances): void {
        $this->attendances = $attendances;
    }
}
