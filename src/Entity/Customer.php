<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=4, nullable=false)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=50, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telPrivat", type="string", length=50, nullable=false)
     */
    private $telprivat;

    /**
     * @var string
     *
     * @ORM\Column(name="telMobile", type="string", length=50, nullable=true)
     */
    private $telmobile;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=70, nullable=false)
     */
    private $street;

    /**
     * @var integer
     *
     * @ORM\Column(name="streetNr", type="integer", nullable=false)
     */
    private $streetnr;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=false)
     */
    private $city;

    /**
     * @var integer
     *
     * @ORM\Column(name="plz", type="integer", nullable=false)
     */
    private $plz;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date", nullable=false)
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date", nullable=true)
     */
    private $enddate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bill", mappedBy="customer", fetch="EAGER")
     */
    private $bills;

    public function __construct()
    {
        $this->bills = new ArrayCollection();
    }

    /**
     * @return Collection|Bill[]
     */
    public function getBills() {
        return $this->bills;
    }

    /**
     * @param mixed $bills
     */
    public function setBills($bills): void {
        $this->bills = $bills;
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
     * @return string
     */
    public function getGender(): ?string {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getFirstname(): ?string {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getSurname(): ?string {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelprivat(): ?string {
        return $this->telprivat;
    }

    /**
     * @param string $telprivat
     */
    public function setTelprivat(string $telprivat): void {
        $this->telprivat = $telprivat;
    }

    /**
     * @return string
     */
    public function getTelmobile(): ?string {
        return $this->telmobile;
    }

    /**
     * @param string $telmobile
     */
    public function setTelmobile(string $telmobile): void {
        $this->telmobile = $telmobile;
    }

    /**
     * @return string
     */
    public function getStreet(): ?string {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void {
        $this->street = $street;
    }

    /**
     * @return int
     */
    public function getStreetnr(): ?int {
        return $this->streetnr;
    }

    /**
     * @param int $streetnr
     */
    public function setStreetnr(int $streetnr): void {
        $this->streetnr = $streetnr;
    }

    /**
     * @return string
     */
    public function getCity(): ?string {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void {
        $this->city = $city;
    }

    /**
     * @return int
     */
    public function getPlz(): ?int {
        return $this->plz;
    }

    /**
     * @param int $plz
     */
    public function setPlz(int $plz): void {
        $this->plz = $plz;
    }

    /**
     * @return \DateTime
     */
    public function getStartdate(): ?\DateTime {
        return $this->startdate;
    }

    /**
     * @param \DateTime $startdate
     */
    public function setStartdate(\DateTime $startdate): void {
        $this->startdate = $startdate;
    }

    /**
     * @return \DateTime
     */
    public function getEnddate(): ?\DateTime {
        return $this->enddate;
    }

    /**
     * @param \DateTime $enddate
     */
    public function setEnddate(\DateTime $enddate): void {
        $this->enddate = $enddate;
    }
}
