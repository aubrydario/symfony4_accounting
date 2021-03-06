<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ApiResource
 * @ApiFilter(NumericFilter::class, properties={"active"})
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
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=false)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telPrivat", type="string", length=50, nullable=true)
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
     * @var string
     *
     * @ORM\Column(name="streetNr", type="string", length=5, nullable=true)
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
     * @var string
     *
     * @ORM\Column(name="memo", type="string", length=512, nullable=true)
     */
    private $memo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bill", mappedBy="customer", fetch="EAGER")
     * @ApiSubresource
     */
    private $bills;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer", nullable=false)
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="customers")
     * @ORM\JoinColumn
     */
    private $user;

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
     * @return \DateTime
     */
    public function getBirthday(): ?\DateTime {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday(\DateTime $birthday): void {
        $this->birthday = $birthday;
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
    public function setEmail(?string $email): void {
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
    public function setTelprivat(?string $telprivat): void {
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
    public function setTelmobile(?string $telmobile): void {
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
     * @return string
     */
    public function getStreetnr(): ?string {
        return $this->streetnr;
    }

    /**
     * @param string $streetnr
     */
    public function setStreetnr(string $streetnr): void {
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
    public function setEnddate(?\DateTime $enddate): void {
        $this->enddate = $enddate;
    }

    /**
     * @return string
     */
    public function getMemo(): ?string
    {
        return $this->memo;
    }

    /**
     * @param string|null $memo
     */
    public function setMemo(?string $memo): void
    {
        $this->memo = $memo;
    }

    /**
     * @return int
     */
    public function getActive(): ?int {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive(int $active): void {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
}
