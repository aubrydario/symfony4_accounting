<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AboRepository")
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
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bill", mappedBy="abo", fetch="EAGER")
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
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPrice(): int {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void {
        $this->price = $price;
    }
}
