<?php namespace MH\Domain\Transaction;

use DateTime;
use MH\Domain\EntityInterface;
use SebastianBergmann\Money\Money;

class Transaction implements EntityInterface
{
    private $id;
    private $guestId;
    private $date;
    private $success;
    private $result;
    private $paymentAmount;
    private $stripeTransactionId;

    public function __construct(
        int $id = null,
        int $guestId = null,
        DateTime $date = null,
        bool $success = false,
        string $result = '',
        Money $paymentAmount = null,
        string $stripeTransactionId = null
    ) {
        $this->id = $id;
        $this->guestId = $guestId;
        $this->date = $date;
        $this->success = $success;
        $this->result = $result;
        $this->paymentAmount = $paymentAmount;
        $this->stripeTransactionId = $stripeTransactionId;
    }

    public function id()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function guestId()
    {
        return $this->guestId;
    }

    public function setGuestId(int $guestId)
    {
        $this->guestId = $guestId;
    }

    public function date()
    {
        return $this->date;
    }

    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    public function success() : bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    public function result() : string
    {
        return $this->result;
    }

    public function setResult(string $result)
    {
        $this->result = $result;
    }

    public function paymentAmount() : Money
    {
        return $this->paymentAmount;
    }

    public function setPaymentAmount(Money $paymentAmount)
    {
        $this->paymentAmount = $paymentAmount;
    }

    public function stripeTransactionId()
    {
        return $this->stripeTransactionId;
    }

    public function setStripeTransactionId(string $stripeTransactionId)
    {
        $this->stripeTransactionId = $stripeTransactionId;
    }

    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'guestId' => $this->guestId,
            'date' => $this->date,
            'result' => $this->result,
            'amount' => $this->amount,
            'stripeTransactionId' => $this->stripeTransactionId
        ];
    }
}