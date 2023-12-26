<?php


declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'oc_order')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $orderId;

    // ... Add all other properties with appropriate attributes ...

    #[ORM\Column(type: 'integer')]
    private $invoiceNo;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'customer_id')]
    private $customerId;

    // ... Other methods ...

    #[ORM\Column(type: 'string', length: 26)]
    private mixed $invoicePrefix;

    // ... Continue adding properties for each table column ...

    #[ORM\Column(type: 'decimal', scale: 4, precision: 15)]
    private mixed $total;

    #[ORM\Column(type: 'string', length: 128)]
    private mixed $paymentAddress_1;

    #[ORM\Column(type: 'string', length: 128, nullable: true)]
    private $paymentAddress_2;

    #[ORM\Column(type: 'string', length: 128)]
    private $paymentCity;

    #[ORM\Column(type: 'string', length: 128)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 128)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 10)]
    private $paymentPostcode;

    #[ORM\Column(type: 'string', length: 128)]
    private $paymentCountry;

    #[ORM\Column(type: 'integer')]
    private $paymentCountryId;

    #[ORM\Column(type: 'string', length: 128)]
    private $paymentZone;

    #[ORM\Column(type: 'integer')]
    private $paymentZoneId;

    #[ORM\Column(type: 'text')]
    private $paymentAddressFormat;

    #[ORM\Column(type: 'string', length: 128)]
    private $paymentMethod;

    #[ORM\Column(type: 'string', length: 128)]
    private $paymentCode;

    #[ORM\Column(type: 'string', length: 32)]
    private $shippingFirstname;

    #[ORM\Column(type: 'string', length: 32)]
    private $shippingLastname;

    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private $shippingCompany;

    #[ORM\Column(type: 'string', length: 128)]
    private $shippingAddress_1;

    #[ORM\Column(type: 'string', length: 128, nullable: true)]
    private $shippingAddress_2;

    #[ORM\Column(type: 'string', length: 128)]
    private $shippingCity;

    #[ORM\Column(type: 'string', length: 10)]
    private $shippingPostcode;

    #[ORM\Column(type: 'string', length: 128)]
    private $shippingCountry;

    #[ORM\Column(type: 'integer')]
    private $shippingCountryId;

    #[ORM\Column(type: 'string', length: 128)]
    private $shippingZone;

    #[ORM\Column(type: 'integer')]
    private $shippingZoneId;

    #[ORM\Column(type: 'text')]
    private $shippingAddressFormat;

    #[ORM\Column(type: 'string', length: 128)]
    private $shippingMethod;

    #[ORM\Column(type: 'string', length: 128)]
    private $shippingCode;

    #[ORM\Column(type: 'text')]
    private $comment;

    #[ORM\Column(type: 'integer')]
    private $orderStatusId;

    #[ORM\Column(type: 'integer')]
    private $affiliateId;

    #[ORM\Column(type: 'decimal', scale: 4, precision: 15)]
    private $commission;

    #[ORM\Column(type: 'integer')]
    private $languageId;

    #[ORM\Column(type: 'integer')]
    private $currencyId;

    #[ORM\Column(type: 'string', length: 3)]
    private $currencyCode;

    #[ORM\Column(type: 'decimal', scale: 8, precision: 15)]
    private $currencyValue;

    #[ORM\Column(type: 'string', length: 40)]
    private $ip;

    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private $forwardedIp;

    #[ORM\Column(type: 'string', length: 255)]
    private $userAgent;

    #[ORM\Column(type: 'string', length: 255)]
    private $acceptLanguage;

    #[ORM\Column(type: 'datetime')]
    private $dateAdded;

    #[ORM\Column(type: 'datetime')]
    private $dateModified;

    #[ORM\Column(type: 'integer')]
    private $operatorId;

    #[ORM\Column(type: 'integer')]
    private $createOperatorId;

    #[ORM\Column(type: 'integer')]
    private $courierId;

    #[ORM\Column(type: 'string', length: 255)]
    private $moysklad;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $moyskladTime;

    #[ORM\Column(type: 'string', length: 255)]
    private $time;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $gmap;

    #[ORM\Column(type: 'string', length: 222, nullable: true)]
    private $paymentAddressNew;

    #[ORM\Column(type: 'string', length: 222, nullable: true)]
    private $longitude;

    #[ORM\Column(type: 'string', length: 222, nullable: true)]
    private $latitude;

    #[ORM\Column(type: 'smallint')]
    private $paymentChecked;


    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="order")
     */
    private ArrayCollection $orderProducts;


    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }


    /**
     * @return Collection
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNo()
    {
        return $this->invoiceNo;
    }

    /**
     * @param mixed $invoiceNo
     */
    public function setInvoiceNo($invoiceNo): void
    {
        $this->invoiceNo = $invoiceNo;
    }

    /**
     * @return mixed
     */
    public function getInvoicePrefix()
    {
        return $this->invoicePrefix;
    }

    /**
     * @param mixed $invoicePrefix
     */
    public function setInvoicePrefix($invoicePrefix): void
    {
        $this->invoicePrefix = $invoicePrefix;
    }

    /**
     * @return mixed
     */
    public function getPaymentAddress1()
    {
        return $this->paymentAddress_1;
    }

    /**
     * @param mixed $paymentAddress1
     */
    public function setPaymentAddress1($paymentAddress1): void
    {
        $this->paymentAddress_1 = $paymentAddress1;
    }

    /**
     * @return mixed
     */
    public function getPaymentAddress2()
    {
        return $this->paymentAddress_2;
    }

    /**
     * @param mixed $paymentAddress2
     */
    public function setPaymentAddress2($paymentAddress2): void
    {
        $this->paymentAddress_2 = $paymentAddress2;
    }

    /**
     * @return mixed
     */
    public function getPaymentCity()
    {
        return $this->paymentCity;
    }

    /**
     * @param mixed $paymentCity
     */
    public function setPaymentCity($paymentCity): void
    {
        $this->paymentCity = $paymentCity;
    }

    /**
     * @return mixed
     */
    public function getPaymentPostcode()
    {
        return $this->paymentPostcode;
    }

    /**
     * @param mixed $paymentPostcode
     */
    public function setPaymentPostcode($paymentPostcode): void
    {
        $this->paymentPostcode = $paymentPostcode;
    }

    /**
     * @return mixed
     */
    public function getPaymentCountry()
    {
        return $this->paymentCountry;
    }

    /**
     * @param mixed $paymentCountry
     */
    public function setPaymentCountry($paymentCountry): void
    {
        $this->paymentCountry = $paymentCountry;
    }

    /**
     * @return mixed
     */
    public function getPaymentCountryId()
    {
        return $this->paymentCountryId;
    }

    /**
     * @param mixed $paymentCountryId
     */
    public function setPaymentCountryId($paymentCountryId): void
    {
        $this->paymentCountryId = $paymentCountryId;
    }

    /**
     * @return mixed
     */
    public function getPaymentZone()
    {
        return $this->paymentZone;
    }

    /**
     * @param mixed $paymentZone
     */
    public function setPaymentZone($paymentZone): void
    {
        $this->paymentZone = $paymentZone;
    }

    /**
     * @return mixed
     */
    public function getPaymentZoneId()
    {
        return $this->paymentZoneId;
    }

    /**
     * @param mixed $paymentZoneId
     */
    public function setPaymentZoneId($paymentZoneId): void
    {
        $this->paymentZoneId = $paymentZoneId;
    }

    /**
     * @return mixed
     */
    public function getPaymentAddressFormat()
    {
        return $this->paymentAddressFormat;
    }

    /**
     * @param mixed $paymentAddressFormat
     */
    public function setPaymentAddressFormat($paymentAddressFormat): void
    {
        $this->paymentAddressFormat = $paymentAddressFormat;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param mixed $paymentMethod
     */
    public function setPaymentMethod($paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return mixed
     */
    public function getPaymentCode()
    {
        return $this->paymentCode;
    }

    /**
     * @param mixed $paymentCode
     */
    public function setPaymentCode($paymentCode): void
    {
        $this->paymentCode = $paymentCode;
    }

    /**
     * @return mixed
     */
    public function getShippingFirstname()
    {
        return $this->shippingFirstname;
    }

    /**
     * @param mixed $shippingFirstname
     */
    public function setShippingFirstname($shippingFirstname): void
    {
        $this->shippingFirstname = $shippingFirstname;
    }

    /**
     * @return mixed
     */
    public function getShippingLastname()
    {
        return $this->shippingLastname;
    }

    /**
     * @param mixed $shippingLastname
     */
    public function setShippingLastname($shippingLastname): void
    {
        $this->shippingLastname = $shippingLastname;
    }

    /**
     * @return mixed
     */
    public function getShippingCompany()
    {
        return $this->shippingCompany;
    }

    /**
     * @param mixed $shippingCompany
     */
    public function setShippingCompany($shippingCompany): void
    {
        $this->shippingCompany = $shippingCompany;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress1()
    {
        return $this->shippingAddress1;
    }

    /**
     * @param mixed $shippingAddress1
     */
    public function setShippingAddress1($shippingAddress1): void
    {
        $this->shippingAddress1 = $shippingAddress1;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress2()
    {
        return $this->shippingAddress2;
    }

    /**
     * @param mixed $shippingAddress2
     */
    public function setShippingAddress2($shippingAddress2): void
    {
        $this->shippingAddress2 = $shippingAddress2;
    }

    /**
     * @return mixed
     */
    public function getShippingCity()
    {
        return $this->shippingCity;
    }

    /**
     * @param mixed $shippingCity
     */
    public function setShippingCity($shippingCity): void
    {
        $this->shippingCity = $shippingCity;
    }

    /**
     * @return mixed
     */
    public function getShippingPostcode()
    {
        return $this->shippingPostcode;
    }

    /**
     * @param mixed $shippingPostcode
     */
    public function setShippingPostcode($shippingPostcode): void
    {
        $this->shippingPostcode = $shippingPostcode;
    }

    /**
     * @return mixed
     */
    public function getShippingCountry()
    {
        return $this->shippingCountry;
    }

    /**
     * @param mixed $shippingCountry
     */
    public function setShippingCountry($shippingCountry): void
    {
        $this->shippingCountry = $shippingCountry;
    }

    /**
     * @return mixed
     */
    public function getShippingCountryId()
    {
        return $this->shippingCountryId;
    }

    /**
     * @param mixed $shippingCountryId
     */
    public function setShippingCountryId($shippingCountryId): void
    {
        $this->shippingCountryId = $shippingCountryId;
    }

    /**
     * @return mixed
     */
    public function getShippingZone()
    {
        return $this->shippingZone;
    }

    /**
     * @param mixed $shippingZone
     */
    public function setShippingZone($shippingZone): void
    {
        $this->shippingZone = $shippingZone;
    }

    /**
     * @return mixed
     */
    public function getShippingZoneId()
    {
        return $this->shippingZoneId;
    }

    /**
     * @param mixed $shippingZoneId
     */
    public function setShippingZoneId($shippingZoneId): void
    {
        $this->shippingZoneId = $shippingZoneId;
    }

    /**
     * @return mixed
     */
    public function getShippingAddressFormat()
    {
        return $this->shippingAddressFormat;
    }

    /**
     * @param mixed $shippingAddressFormat
     */
    public function setShippingAddressFormat($shippingAddressFormat): void
    {
        $this->shippingAddressFormat = $shippingAddressFormat;
    }

    /**
     * @return mixed
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param mixed $shippingMethod
     */
    public function setShippingMethod($shippingMethod): void
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * @return mixed
     */
    public function getShippingCode()
    {
        return $this->shippingCode;
    }

    /**
     * @param mixed $shippingCode
     */
    public function setShippingCode($shippingCode): void
    {
        $this->shippingCode = $shippingCode;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
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
    public function getOrderStatusId()
    {
        return $this->orderStatusId;
    }

    /**
     * @param mixed $orderStatusId
     */
    public function setOrderStatusId($orderStatusId): void
    {
        $this->orderStatusId = $orderStatusId;
    }

    /**
     * @return mixed
     */
    public function getAffiliateId()
    {
        return $this->affiliateId;
    }

    /**
     * @param mixed $affiliateId
     */
    public function setAffiliateId($affiliateId): void
    {
        $this->affiliateId = $affiliateId;
    }

    /**
     * @return mixed
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param mixed $commission
     */
    public function setCommission($commission): void
    {
        $this->commission = $commission;
    }

    /**
     * @return mixed
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * @param mixed $languageId
     */
    public function setLanguageId($languageId): void
    {
        $this->languageId = $languageId;
    }

    /**
     * @return mixed
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    /**
     * @param mixed $currencyId
     */
    public function setCurrencyId($currencyId): void
    {
        $this->currencyId = $currencyId;
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param mixed $currencyCode
     */
    public function setCurrencyCode($currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return mixed
     */
    public function getCurrencyValue()
    {
        return $this->currencyValue;
    }

    /**
     * @param mixed $currencyValue
     */
    public function setCurrencyValue($currencyValue): void
    {
        $this->currencyValue = $currencyValue;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getForwardedIp()
    {
        return $this->forwardedIp;
    }

    /**
     * @param mixed $forwardedIp
     */
    public function setForwardedIp($forwardedIp): void
    {
        $this->forwardedIp = $forwardedIp;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param mixed $userAgent
     */
    public function setUserAgent($userAgent): void
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return mixed
     */
    public function getAcceptLanguage()
    {
        return $this->acceptLanguage;
    }

    /**
     * @param mixed $acceptLanguage
     */
    public function setAcceptLanguage($acceptLanguage): void
    {
        $this->acceptLanguage = $acceptLanguage;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     */
    public function setDateAdded($dateAdded): void
    {
        $this->dateAdded = $dateAdded;
    }

    /**
     * @return mixed
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param mixed $dateModified
     */
    public function setDateModified($dateModified): void
    {
        $this->dateModified = $dateModified;
    }

    /**
     * @return mixed
     */
    public function getOperatorId()
    {
        return $this->operatorId;
    }

    /**
     * @param mixed $operatorId
     */
    public function setOperatorId($operatorId): void
    {
        $this->operatorId = $operatorId;
    }

    /**
     * @return mixed
     */
    public function getCreateOperatorId()
    {
        return $this->createOperatorId;
    }

    /**
     * @param mixed $createOperatorId
     */
    public function setCreateOperatorId($createOperatorId): void
    {
        $this->createOperatorId = $createOperatorId;
    }

    /**
     * @return mixed
     */
    public function getCourierId()
    {
        return $this->courierId;
    }

    /**
     * @param mixed $courierId
     */
    public function setCourierId($courierId): void
    {
        $this->courierId = $courierId;
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
    public function getMoyskladTime()
    {
        return $this->moyskladTime;
    }

    /**
     * @param mixed $moyskladTime
     */
    public function setMoyskladTime($moyskladTime): void
    {
        $this->moyskladTime = $moyskladTime;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time): void
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getGmap()
    {
        return $this->gmap;
    }

    /**
     * @param mixed $gmap
     */
    public function setGmap($gmap): void
    {
        $this->gmap = $gmap;
    }

    /**
     * @return mixed
     */
    public function getPaymentAddressNew()
    {
        return $this->paymentAddressNew;
    }

    /**
     * @param mixed $paymentAddressNew
     */
    public function setPaymentAddressNew($paymentAddressNew): void
    {
        $this->paymentAddressNew = $paymentAddressNew;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getPaymentChecked()
    {
        return $this->paymentChecked;
    }

    /**
     * @param mixed $paymentChecked
     */
    public function setPaymentChecked($paymentChecked): void
    {
        $this->paymentChecked = $paymentChecked;
    }

    // ... Add here getters and setters for all properties


}
