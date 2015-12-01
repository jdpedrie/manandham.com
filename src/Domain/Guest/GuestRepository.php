<?php namespace MH\Domain\Guest;

use PDO;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

class GuestRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all() : array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM guests');
        $stmt->execute();

        $res = [];
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $guest) {
            $res[] = $this->mapper($guest);
        }

        return $res;
    }

    public function get(int $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM guests WHERE id = :id');
        $stmt->bindValue('id', $id);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_OBJ);

        if ($res === FALSE) {
            return null;
        }

        return $this->mapper($res);
    }

    public function find($first, $last)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM guests
            WHERE firstName LIKE :firstName
            AND lastName LIKE :lastName');

        $stmt->bindValue('firstName', '%'. $first .'%');
        $stmt->bindValue('lastName', '%'. $last .'%');
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_OBJ);

        if ($res === FALSE) {
            return null;
        }

        return $this->mapper($res);
    }

    public function save(Guest $guest)
    {
        if (is_null($guest->id())) {
            // insert
            $stmt = $this->pdo->prepare('INSERT INTO guests
                (firstName, lastName, emailAddress, phoneNumber, address, paymentAmount)
                VALUES
                (:firstName, :lastName, :emailAddress,
                 :phoneNumber, :address, :paymentAmount)');
        }
        else {
            // update
            $stmt = $this->pdo->prepare('UPDATE guests
                SET firstName = :firstName,
                    lastName = :lastName,
                    emailAddress = :emailAddress,
                    phoneNumber = :phoneNumber,
                    address = :address,
                    paymentAmount = :paymentAmount
                WHERE id = :guestId');

            $stmt->bindValue('guestId', $guest->id());
        }

        $stmt->bindValue('firstName', $guest->firstName());
        $stmt->bindValue('lastName', $guest->lastName());
        $stmt->bindValue('emailAddress', $guest->emailAddress());
        $stmt->bindValue('phoneNumber', $guest->phoneNumber());
        $stmt->bindValue('address', $guest->address());
        $stmt->bindValue('paymentAmount', $guest->paymentAmount()->getConvertedAmount());

        return $stmt->execute();
    }

    private function mapper(\stdClass $guest) : Guest
    {
        $paymentAmount = Money::fromString((string) $guest->paymentAmount, new Currency('USD'));
        return new Guest(
            $guest->id,
            $guest->firstName,
            $guest->lastName,
            $guest->emailAddress,
            $guest->phoneNumber,
            $guest->address,
            $paymentAmount
        );
    }
}