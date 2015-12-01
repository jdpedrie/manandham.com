<?php namespace MH\Domain\Guest;

use MH\Domain\EntityInterface;
use SebastianBergmann\Money\Money;

class Guest implements EntityInterface
{
    private $id;
    private $firstName;
    private $lastName;
    private $emailAddress;
    private $phoneNumber;
    private $address;
    private $paymentAmount;

    public function __construct(
        int $id = null,
        string $firstName = null,
        string $lastName = null,
        string $emailAddress = null,
        $phoneNumber = null,
        string $address = null,
        Money $paymentAmount
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->emailAddress = $emailAddress;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->paymentAmount = $paymentAmount;
    }

    public function id() : int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function lastName() : string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function emailAddress() : string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    public function phoneNumber() : int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function address() : string
    {
        return $this->address;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    public function paymentAmount() : Money
    {
        return $this->paymentAmount;
    }

    public function setPaymentAmount(Money $paymentAmount)
    {
        $this->paymentAmount = $paymentAmount;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'emailAddress' => $this->emailAddress,
            'phoneNumber' => $this->phoneNumber,
            'address' => $this->address,
        ];
    }
}
