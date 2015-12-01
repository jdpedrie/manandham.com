<?php declare(strict_types=1); namespace MH\Controller;

use DateTime;
use League\Plates\Engine as Template;
use MH\Domain\Guest\Guest;
use MH\Domain\Guest\GuestRepository;
use MH\Domain\Transaction\TransactionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class TransactionController implements ControllerInterface
{
    private $transaction;

    private $guest;

    private $template;

    private $isAdmin;

    public function __construct(
        TransactionRepository $transaction,
        GuestRepository $guest,
        Template $template,
        bool $isAdmin
    ) {
        $this->transaction = $transaction;
        $this->guest = $guest;
        $this->template = $template;
        $this->isAdmin = $isAdmin;
    }

    public function pay(Request $request, $id)
    {
        $transaction = $this->transaction->create(
            null,
            (int) $id,
            new DateTime
        );

        $guest = $this->guest->get((int) $id);
        if (is_null($guest)) {
            return new Response('', 301, [
                'location' => '/not-found'
            ]);
        }

        $previousTransactions = $this->transaction->getByGuest($guest);
        foreach ($previousTransactions as $t) {
            if ($t->success() === true) {
                return new Response('', 301, [
                    'location' => '/thank-you'
                ]);
            }
        }

        $this->updateGuestInfo($guest, $request->request);
        $paymentToken = $request->request->get('stripeToken');

        $transaction->setPaymentAmount($guest->paymentAmount());
        $transaction->setGuestId($guest->id());

        $result = $this->transaction->charge(
            $transaction,
            $paymentToken,
            $guest->emailAddress(),
            sprintf('%s %s', $guest->firstName(), $guest->lastName())
        );

        $this->transaction->save($result);

        if ($result->success()) {
            $loc = '/thank-you';
        }
        else {
            $loc = sprintf('pay/%d/?paymentError', $guest->id());
        }

        return new Response('', 301, [
            'location' => $loc
        ]);
    }

    private function updateGuestInfo(Guest $guest, ParameterBag $input)
    {
        $guest->setFirstName($input->get('firstName'));
        $guest->setLastName($input->get('lastName'));
        $guest->setEmailAddress($input->get('emailAddress'));
        $guest->setPhoneNumber((int)$input->get('phoneNumber'));
        $guest->setAddress($input->get('address'));
        $this->guest->save($guest);

        return $guest;
    }
}