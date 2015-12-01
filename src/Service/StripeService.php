<?php namespace MH\Service;

use Stripe;

class StripeService
{
    public function charge(int $amount, string $token, string $description, string $emailAddress) : string
    {
        $charge = Stripe\Charge::create([
            "amount" => $amount,
            "currency" => "usd",
            "source" => $token,
            "description" => $description,
            "receipt_email" => $emailAddress,
            "statement_descriptor" => "M&H X"
        ]);

        return $charge['id'];
    }
}