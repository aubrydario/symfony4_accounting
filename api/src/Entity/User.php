<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ApiResource()
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="Benutzername bereits vergeben")
 * @UniqueEntity(fields="email", message="Email wird bereits verwendet")
 */
class User extends BaseUse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Der Name ist zu lang.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Der Name ist zu lang.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $lastname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Payment", mappedBy="user")
     * @ApiSubresource
     */
    private $payments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hour", mappedBy="user")
     * @ApiSubresource
     */
    private $hours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Abo", mappedBy="user")
     * @ApiSubresource
     */
    private $abos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="user")
     * @ApiSubresource
     */
    private $customers;

    public function __construct()
    {
        parent::__construct();

        $this->payments = new ArrayCollection();
        $this->hours = new ArrayCollection();
        $this->abos = new ArrayCollection();
        $this->customers = new ArrayCollection();
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments() {
        return $this->payments;
    }

    /**
     * @param mixed $payments
     */
    public function setPayments($payments): void {
        $this->payments = $payments;
    }

    /**
     * @return Collection|Hour[]
     */
    public function getHours() {
        return $this->hours;
    }

    /**
     * @param mixed $hours
     */
    public function setHours($hours): void {
        $this->hours = $hours;
    }

    /**
     * @return Collection|Abo[]
     */
    public function getAbos() {
        return $this->abos;
    }

    /**
     * @param mixed $abos
     */
    public function setAbos($abos): void {
        $this->abos = $abos;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers() {
        return $this->customers;
    }

    /**
     * @param mixed $customers
     */
    public function setCustomers($customers): void {
        $this->customers = $customers;
    }

    /**
     * Get the value of Firstname
     *
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of Firstname
     *
     * @param mixed $firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of Lastname
     *
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of Lastname
     *
     * @param mixed $lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

}
