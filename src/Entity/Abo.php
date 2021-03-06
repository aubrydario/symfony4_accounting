<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AboRepository")
 * @ApiResource
 */
class Abo
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=50, nullable=false)
     */
    private $alias;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     * @Groups("bill-abo")
     */
    private $price;

    /**
     * @ORM\Column(name="maxVisits", type="integer", nullable=false)
     */
    private $maxVisits;

    /**
     * @ORM\Column(name="maxDays", type="integer", nullable=false)
     */
    private $maxDays;

    /**
     * @ORM\Column(name="color", type="string", length=7, nullable=false)
     */
    private $color;

    /**
     * @ORM\Column(name="extra", type="string", length=300, nullable=true)
     */
    private $extra;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bill", mappedBy="abo")
     */
    private $bills;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="abos")
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
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return int
     */
    public function getPrice(): ?int {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getMaxVisits() {
        return $this->maxVisits;
    }

    /**
     * @param mixed $maxVisits
     */
    public function setMaxVisits($maxVisits): void {
        $this->maxVisits = $maxVisits;
    }

    /**
     * @return mixed
     */
    public function getMaxDays() {
        return $this->maxDays;
    }

    /**
     * @param mixed $maxDays
     */
    public function setMaxDays($maxDays): void {
        $this->maxDays = $maxDays;
    }

    /**
     * @return mixed
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param mixed $extra
     */
    public function setExtra($extra): void
    {
        $this->extra = $extra;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void {
        $this->user = $user;
    }
}
