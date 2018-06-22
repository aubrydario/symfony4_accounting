<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Serializer\Filter\GroupFilter;


/**
 * @ORM\Entity(repositoryClass="App\Repository\BillRepository")
 * @ApiResource(attributes={
 *   "normalization_context"={"groups"={"bill-abo"}}
 * })
 * @ApiFilter(GroupFilter::class, arguments={"overrideDefaultGroups": true, "whitelist": {"lazy"}})
 */
class Bill {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("lazy")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     * @Groups("bill-abo")
     * @Groups("lazy")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date", nullable=false)
     * @Groups("lazy")
     */
    private $enddate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="bills")
     * @ORM\JoinColumn
     * @ApiSubresource
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Abo", inversedBy="bills")
     * @ORM\JoinColumn
     * @ApiSubresource
     * @Groups("bill-abo")
     */
    private $abo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Attendance", mappedBy="bill")
     * @ApiSubresource
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
     * @return \DateTime
     */
    public function getEnddate(): \DateTime {
        return $this->enddate;
    }

    /**
     * @param \DateTime $enddate
     */
    public function setEnddate(\DateTime $enddate): void {
        $this->enddate = $enddate;
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
