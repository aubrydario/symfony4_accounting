<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\BillRepository")
 */
class Bill
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="bills")
     * @ORM\JoinColumn
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Abo", inversedBy="bills")
     * @ORM\JoinColumn
     */
    private $abo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Attendance", mappedBy="bill", fetch="EAGER")
     */
    private $attendances;

    public function __construct()
    {
        $this->attendances = new ArrayCollection();
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
    public function getCustomer() {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer): void {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getAbo() {
        return $this->abo;
    }

    /**
     * @param mixed $abo
     */
    public function setAbo($abo): void {
        $this->abo = $abo;
    }
}
