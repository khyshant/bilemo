<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column
     */
    private $path;

    /**
     * @var UploadedFile|null
     * @Assert\Image
     * @Assert\NotNull(groups={"add"})
     */
    private $uploadedFile;

    /**
     * @var Product|null
     * @ORM\ManyToOne(targetEntity="product", inversedBy="images")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $product;

    /**
     * @var Brand|null
     * @ORM\ManyToOne(targetEntity="brand", inversedBy="images")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $brand;

    /**
     * @var Category|null
     * @ORM\ManyToOne(targetEntity="category", inversedBy="images")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return UploadedFile|null
     */
    public function getUploadedFile(): ?UploadedFile
    {
        return $this->uploadedFile;
    }

    /**
     * @param UploadedFile|null $uploadedFile
     */
    public function setUploadedFile(?UploadedFile $uploadedFile): void
    {
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     */
    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand|null $brand
     */
    public function setBrand(?Brand $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }


}
