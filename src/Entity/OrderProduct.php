<?php

namespace App\Entity;

use App\Repository\OrderProductRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
#[ORM\Table(name: 'oc_order_product')]
class OrderProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'order_product_id', type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'order_id')]
    private $order;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'product_id')]
    private $product;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 64)]
    private $model;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    private $quantity;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 4)]
    private $price;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 4)]
    private $total;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 4)]
    private $tax;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 4)]
    private $reward;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param mixed $tax
     */
    public function setTax($tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return mixed
     */
    public function getReward()
    {
        return $this->reward;
    }

    /**
     * @param mixed $reward
     */
    public function setReward($reward): void
    {
        $this->reward = $reward;
    }

    // Add your getters and setters here
}