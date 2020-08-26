<?php

namespace NetsCheckoutPayment\Models;

use Shopware\Components\Model\ModelEntity;
use Shopware\Models\Order\Order;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="nets_checkout_payments")
 */
class NetsCheckoutPayment extends ModelEntity
{
    /**
     * Primary Key - autoincrement value
     *
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="order_id", type="string")
     *
     * @var string
     */
    protected $orderId;

    /**
     * @ORM\Column(name="nets_payment_id", type="string")
     *
     * @var string
     */
    protected $netsPaymentId;

    /**
     * @ORM\Column(name="amount_authorized", type="integer")
     *
     * @var integer
     */
    protected $amountAuthorized;

    /**
     * @ORM\Column(name="amount_captured", type="integer")
     *
     * @var integer
     */
    protected $amountCaptured;

    /**
     * @ORM\Column(name="amount_refunded", type="integer")
     *
     * @var integer
     */
    protected $amountRefunded;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     *
     * @var \DateTime Date of creation
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="paytype", type="string")
     *
     * @var string
     */
    protected $paytype;

    /**
     * @ORM\Column(name="is_cancelled", type="integer")
     *
     * @var string
     */
    protected $isCancelled;

    /**
     * @ORM\Column(name="items_json", type="text")
     *
     * @var string
     */
    protected $itemsJson;

    public function __construct()
    {
        $this->createdAt =  new DateTime();
        $this->amountAuthorized = 0;
        $this->amountCaptured = 0;
        $this->amountRefunded = 0;
        $this->isCancelled = 0;
    }

    /**
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * get the object of the linked order
     *
     * @return Order
     */
    public function getOrder()
    {
        if($this->orderNumber == null)
        {
            return null;
        }

        $rep = Shopware()->Models()->getRepository(Order::class);
        return $rep->findOneBy(['number' => $this->orderNumber]);
    }

    /**
     *
     * @return integer amount in cents
     */
    public function getAmountAuthorized()
    {
        return $this->amountAuthorized;
    }

    /**
     *
     * @param integer $amount amount in cents
     */
    public function setAmountAuthorized($amount)
    {
        $this->amountAuthorized = $amount;
    }

    /**
     *
     * @return integer amount in cents
     */
    public function getAmountCaptured()
    {
        return $this->amountCaptured;
    }

    /**
     *
     * @param integer $amount amount in cents
     */
    public function setAmountCaptured($amount)
    {
        $this->amountCaptured = $amount;
    }

    /**
     *
     * @return integer amount in cents
     */
    public function getAmountRefunded()
    {
        return $this->amountRefunded;
    }

    /**
     *
     * @param integer $amount amount in cents
     */
    public function setAmountRefunded($amount)
    {
        $this->amountRefunded = $amount;
    }

    public function setItemsJson($itemsJson) {
        $this->itemsJson = $itemsJson;
    }

    public function getItemsJson() {
        return $this->itemsJson;
    }

    public function getNetsPaymentId()
    {
        return $this->netsPaymentId;
    }

    public function setNetsPaymentId($paymentId)
    {
        $this->netsPaymentId = $paymentId;
    }

    public function setPaytype($paytype) {
        $this->paytype = $paytype;
    }

    public function getPaytype() {
        return $this->paytype;
    }

    public function setIsCancelled($isCancelled)
    {
        $this->isCancelled = $isCancelled;
    }

    public function getIsCancelled()
    {
        return $this->isCancelled;
    }

}