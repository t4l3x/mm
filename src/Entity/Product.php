<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]

#[ORM\Table(name: 'oc_product')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'product_id', type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 64)]
    private $model;

    #[ORM\Column(type: 'string', length: 64)]
    private $sku;

    #[ORM\Column(type: 'string', length: 12)]
    private $upc;

    #[ORM\Column(type: 'string', length: 14)]
    private $ean;

    #[ORM\Column(type: 'string', length: 13)]
    private $jan;

    #[ORM\Column(type: 'string', length: 13)]
    private $isbn;

    #[ORM\Column(type: 'string', length: 64)]
    private $mpn;

    #[ORM\Column(type: 'string', length: 128)]
    private $location;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    private $quantity;

    #[ORM\Column(type: 'integer')]
    private $stock_status_id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'integer')]
    private $manufacturer_id;

    #[ORM\Column(type: 'boolean')]
    private $shipping;

    #[ORM\Column(type: 'integer')]
    private $country_id;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 4)]
    private $price;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 4)]
    private $wholesale;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    private $points;

    #[ORM\Column(type: 'integer')]
    private $tax_class_id;

    #[ORM\Column(type: 'date')]
    private $date_available;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8)]
    private $weight;

    #[ORM\Column(type: 'integer')]
    private $weight_class_id;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8)]
    private $length;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8)]
    private $width;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8)]
    private $height;

    #[ORM\Column(type: 'integer')]
    private $length_class_id;

    #[ORM\Column(type: 'boolean')]
    private $subtract;

    #[ORM\Column(type: 'integer')]
    private $minimum;

    #[ORM\Column(type: 'integer')]
    private $sort_order;

    #[ORM\Column(type: 'boolean')]
    private $status;

    #[ORM\Column(type: 'datetime')]
    private $date_added;

    #[ORM\Column(type: 'datetime')]
    private $date_modified;

    #[ORM\Column(type: 'integer')]
    private $viewed;

    #[ORM\Column(type: 'boolean')]
    private $razves;

    #[ORM\Column(type: 'integer')]
    private $razves_step;

    #[ORM\Column(type: 'string', length: 50)]
    private $moysklad;

    #[ORM\Column(type: 'boolean')]
    private $component;

    #[ORM\Column(type: 'boolean')]
    private $bag;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 4, nullable: true)]
    private $bagPrice;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8, nullable: true)]
    private $bagWeight;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bagName;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $special_rating;

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
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getUpc()
    {
        return $this->upc;
    }

    /**
     * @param mixed $upc
     */
    public function setUpc($upc): void
    {
        $this->upc = $upc;
    }

    /**
     * @return mixed
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * @param mixed $ean
     */
    public function setEan($ean): void
    {
        $this->ean = $ean;
    }

    /**
     * @return mixed
     */
    public function getJan()
    {
        return $this->jan;
    }

    /**
     * @param mixed $jan
     */
    public function setJan($jan): void
    {
        $this->jan = $jan;
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param mixed $isbn
     */
    public function setIsbn($isbn): void
    {
        $this->isbn = $isbn;
    }

    /**
     * @return mixed
     */
    public function getMpn()
    {
        return $this->mpn;
    }

    /**
     * @param mixed $mpn
     */
    public function setMpn($mpn): void
    {
        $this->mpn = $mpn;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
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
    public function getStockStatusId()
    {
        return $this->stock_status_id;
    }

    /**
     * @param mixed $stock_status_id
     */
    public function setStockStatusId($stock_status_id): void
    {
        $this->stock_status_id = $stock_status_id;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getManufacturerId()
    {
        return $this->manufacturer_id;
    }

    /**
     * @param mixed $manufacturer_id
     */
    public function setManufacturerId($manufacturer_id): void
    {
        $this->manufacturer_id = $manufacturer_id;
    }

    /**
     * @return mixed
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param mixed $shipping
     */
    public function setShipping($shipping): void
    {
        $this->shipping = $shipping;
    }

    /**
     * @return mixed
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * @param mixed $country_id
     */
    public function setCountryId($country_id): void
    {
        $this->country_id = $country_id;
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
    public function getWholesale()
    {
        return $this->wholesale;
    }

    /**
     * @param mixed $wholesale
     */
    public function setWholesale($wholesale): void
    {
        $this->wholesale = $wholesale;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points): void
    {
        $this->points = $points;
    }

    /**
     * @return mixed
     */
    public function getTaxClassId()
    {
        return $this->tax_class_id;
    }

    /**
     * @param mixed $tax_class_id
     */
    public function setTaxClassId($tax_class_id): void
    {
        $this->tax_class_id = $tax_class_id;
    }

    /**
     * @return mixed
     */
    public function getDateAvailable()
    {
        return $this->date_available;
    }

    /**
     * @param mixed $date_available
     */
    public function setDateAvailable($date_available): void
    {
        $this->date_available = $date_available;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getWeightClassId()
    {
        return $this->weight_class_id;
    }

    /**
     * @param mixed $weight_class_id
     */
    public function setWeightClassId($weight_class_id): void
    {
        $this->weight_class_id = $weight_class_id;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length): void
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width): void
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height): void
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getLengthClassId()
    {
        return $this->length_class_id;
    }

    /**
     * @param mixed $length_class_id
     */
    public function setLengthClassId($length_class_id): void
    {
        $this->length_class_id = $length_class_id;
    }

    /**
     * @return mixed
     */
    public function getSubtract()
    {
        return $this->subtract;
    }

    /**
     * @param mixed $subtract
     */
    public function setSubtract($subtract): void
    {
        $this->subtract = $subtract;
    }

    /**
     * @return mixed
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @param mixed $minimum
     */
    public function setMinimum($minimum): void
    {
        $this->minimum = $minimum;
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }

    /**
     * @param mixed $sort_order
     */
    public function setSortOrder($sort_order): void
    {
        $this->sort_order = $sort_order;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->date_added;
    }

    /**
     * @param mixed $date_added
     */
    public function setDateAdded($date_added): void
    {
        $this->date_added = $date_added;
    }

    /**
     * @return mixed
     */
    public function getDateModified()
    {
        return $this->date_modified;
    }

    /**
     * @param mixed $date_modified
     */
    public function setDateModified($date_modified): void
    {
        $this->date_modified = $date_modified;
    }

    /**
     * @return mixed
     */
    public function getViewed()
    {
        return $this->viewed;
    }

    /**
     * @param mixed $viewed
     */
    public function setViewed($viewed): void
    {
        $this->viewed = $viewed;
    }

    /**
     * @return mixed
     */
    public function getRazves()
    {
        return $this->razves;
    }

    /**
     * @param mixed $razves
     */
    public function setRazves($razves): void
    {
        $this->razves = $razves;
    }

    /**
     * @return mixed
     */
    public function getRazvesStep()
    {
        return $this->razves_step;
    }

    /**
     * @param mixed $razves_step
     */
    public function setRazvesStep($razves_step): void
    {
        $this->razves_step = $razves_step;
    }

    /**
     * @return mixed
     */
    public function getMoysklad()
    {
        return $this->moysklad;
    }

    /**
     * @param mixed $moysklad
     */
    public function setMoysklad($moysklad): void
    {
        $this->moysklad = $moysklad;
    }

    /**
     * @return mixed
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @param mixed $component
     */
    public function setComponent($component): void
    {
        $this->component = $component;
    }

    /**
     * @return mixed
     */
    public function getBag()
    {
        return $this->bag;
    }

    /**
     * @param mixed $bag
     */
    public function setBag($bag): void
    {
        $this->bag = $bag;
    }

    /**
     * @return mixed
     */
    public function getBagPrice()
    {
        return $this->bagPrice;
    }

    /**
     * @param mixed $bagPrice
     */
    public function setBagPrice($bagPrice): void
    {
        $this->bagPrice = $bagPrice;
    }

    /**
     * @return mixed
     */
    public function getBagWeight()
    {
        return $this->bagWeight;
    }

    /**
     * @param mixed $bagWeight
     */
    public function setBagWeight($bagWeight): void
    {
        $this->bagWeight = $bagWeight;
    }

    /**
     * @return mixed
     */
    public function getBagName()
    {
        return $this->bagName;
    }

    /**
     * @param mixed $bagName
     */
    public function setBagName($bagName): void
    {
        $this->bagName = $bagName;
    }

    /**
     * @return mixed
     */
    public function getSpecialRating()
    {
        return $this->special_rating;
    }

    /**
     * @param mixed $special_rating
     */
    public function setSpecialRating($special_rating): void
    {
        $this->special_rating = $special_rating;
    }

    // Add your getters and setters here
}
