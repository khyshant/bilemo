<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=800, nullable=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=800, nullable=true)
     */
    private $description;

    /**
     * @var float
     * @ORM\Column(name="height", type="float", length=800, nullable=true)
     */
    private $height;

    /**
     * @var float
     * @ORM\Column(name="weight", type="float", length=800, nullable=true)
     */
    private $weight;

    /**
     * @var float
     * @ORM\Column(name="stock", type="float", length=800, nullable=true)
     */
    private $stock;

    /**
     * @var string
     * @ORM\Column(name="price", type="flloat", length=800, nullable=true)
     */
    private $price;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Image", mappedBy="Product", orphanRemoval=true, cascade={"persist"})
     * @Assert\Count(min=1)
     * @Assert\Valid
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @param float $height
     */
    public function setHeight(float $height): void
    {
        $this->height = $height;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return float
     */
    public function getStock(): float
    {
        return $this->stock;
    }

    /**
     * @param float $stock
     */
    public function setStock(float $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param Image $image
     */
    public function addImage(Image $image)
    {
        $image->setTrick($this);
        $this->images->add($image);
    }

    public function removeImage(Image $image)
    {
        $image->setTrick(null);
        $this->images->removeElement($image);
    }

    /**
     * @param Collection $images
     */
    public function setImages(Collection $images): void
    {
        $this->images = $images;
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getTrick() === $this) {
                $image->setTrick(null);
            }
        }
    }
    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }



}
