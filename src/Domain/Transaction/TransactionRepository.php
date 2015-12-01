<?php declare(strict_types=1); namespace MH\Domain\Transaction;

use DateTime;
use MH\Domain\Guest\Guest;
use MH\Service\StripeService;
use PDO;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\USD;
use Stripe\Error\Base as StripeException;

class TransactionRepository
{
    private $pdo;

    private $service;

    public function __construct(PDO $pdo, StripeService $service)
    {
        $this->pdo = $pdo;
        $this->service = $service;
    }

    public function create(...$args) : Transaction
    {
        return new Transaction(...$args);
    }

    public function save(Transaction $transaction)
    {
        if (is_null($transaction->id())) {
            $stmt = $this->pdo->prepare(
                "INSERT INTO
                    transactions(guestId, stripeTransactionId, date, success, result, paymentAmount)
                    VALUES(:guestId, :stripeTransactionId, :date, :success, :result, :paymentAmount)
                "
            );
        }
        else {
            $stmt = $this->pdo->prepare(
                "UPDATE transactions
                    SET guestId = :guestId,
                        stripeTransactionId = :stripeTransactionId,
                        date = :date,
                        success = :success,
                        result = :result,
                        paymentAmount = :paymentAmount
                    WHERE transactionId = :transactionId
                "
            );

            $stmt->bindValue(':transactionId', $transaction->id());
        }

        $stmt->bindValue(':guestId', $transaction->guestId());
        $stmt->bindValue(':stripeTransactionId', $transaction->stripeTransactionId());
        $stmt->bindValue(':date', $transaction->date()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':success', (int) $transaction->success());
        $stmt->bindValue(':result', $transaction->result());
        $stmt->bindValue(':paymentAmount', ($transaction->paymentAmount()->getAmount() / 100));

        return $stmt->execute();
    }

    public function getByGuest(Guest $guest)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE guestId = :guestId');
        $stmt->bindValue(':guestId', $guest->id());
        $stmt->execute();

        $res = [];
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $transaction) {
            $res[] = $this->mapper($transaction);
        }

        return $res;
    }

    public function charge(Transaction $transaction, string $paymentToken, string $emailAddress, string $fromName)  : Transaction
    {
        try {
            $transactionId = $this->service->charge(
                $transaction->paymentAmount()->getAmount(),
                $paymentToken,
                $fromName,
                $emailAddress
            );

            $transaction->setSuccess(true);
            $transaction->setStripeTransactionId($transactionId);
        }
        catch(StripeException $e) {
            $transaction->setSuccess(false);
            $transaction->setResult($e->getMessage());
            $transaction->setPaymentAmount(new USD(0));
        }

        return $transaction;
    }

    private function mapper(\stdClass $transaction) : Transaction
    {
        $paymentAmount = Money::fromString((string) $transaction->paymentAmount, new Currency('USD'));
        return new Transaction(
            (int) $transaction->id,
            (int) $transaction->guestId,
            new DateTime($transaction->date),
            (bool) $transaction->success,
            $transaction->result,
            $paymentAmount,
            $transaction->stripeTransactionId
        );
    }
}