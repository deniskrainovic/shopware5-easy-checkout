<?php


namespace NetsCheckoutPayment\Models;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
use DateTime;


/**
 * @ORM\Entity
 * @ORM\Table(name="nets_checkout_payments_api_operations")
 */
class NetsCheckoutPaymentApiOperations extends ModelEntity
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
    protected $id;

    /**
     * @ORM\Column(name="order_id", type="string")
     *
     * @var string
     */
    protected $orderId;

    /**
     * @ORM\Column(name="operation_id", type="string", nullable=false)
     *
     * @var string
     */
    protected $operationId;

    /**
     * @ORM\Column(name="operation_type", type="string" ,columnDefinition="ENUM('capture', 'refund', 'cancel')")
     *
     * @var string
     */
    protected $operationType;


    /**
     * @ORM\Column(name="operation_amount", type="integer")
     *
     * @var integer
     */
    protected $operationAmount;

    /**
     * @ORM\Column(name="amount_available", type="integer")
     *
     * @var integer
     */
    protected $amountAvailable;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     *
     * @var \DateTime Date of creation
     */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt =  new DateTime();
        $this->setOperationAmount(0);
        $this->setAmountAvailable(0);
    }


    public function setOrderId($orderId) {
        $this->orderId = $orderId;
    }

    public function setOperationId($operationId) {
        $this->operationId = $operationId;
    }

    public function setOperationType($operationType) {
        $this->operationType = $operationType;
    }

    public function setOperationAmount($operationAmount) {
        $this->operationAmount = $operationAmount;
    }

    public function setAmountAvailable($amountAvailable) {
        $this->amountAvailable = $amountAvailable;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getId() {
        return $this->id;
    }

    public function getOrderId() {
        return $this->orderId;
    }

    public function getOperationId() {
        return $this->operationId;
    }

    public function getOperationType() {
        return $this->operationType;
    }

    public function getOperationAmount() {
        return $this->operationAmount;
    }

    public function getAmountAvailable() {
        return $this->amountAvailable;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }
}