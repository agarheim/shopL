<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CatalogsRepository")
 * @ORM\Table(name="catalogs")
 */
class Catalogs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="catalogs")
     */
    private $productss;

    public function __construct()
    {
        $this->productss = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return Collection|Product[]
     */
    public function getProductss(): Collection
    {
        return $this->productss;
    }

    public function addProductss(Product $productss): self
    {
        if (!$this->productss->contains($productss)) {
            $this->productss[] = $productss;
            $productss->setCatalogs($this);
        }

        return $this;
    }

    public function removeProductss(Product $productss): self
    {
        if ($this->productss->contains($productss)) {
            $this->productss->removeElement($productss);
            // set the owning side to null (unless already changed)
            if ($productss->getCatalogs() === $this) {
                $productss->setCatalogs(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return (string)$this->name;
    }
}

