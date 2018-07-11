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
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

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

    public function __construct()
    {
        parent::__construct();

        $this->payments = new ArrayCollection();
        $this->hours = new ArrayCollection();
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
}
