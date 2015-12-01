<?php namespace MH\Controller;

use League\Plates\Engine as Template;
use MH\Domain\Guest\GuestRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GuestController implements ControllerInterface
{
    private $guest;

    private $template;

    private $isAdmin;

    public function __construct(
        GuestRepository $guest,
        Template $template,
        bool $isAdmin
    ) {
        $this->guest = $guest;
        $this->template = $template;
        $this->isAdmin = $isAdmin;
    }

    public function index() : Response
    {
        $guests = $this->guest->all();
        return new Response($guests);
    }

    public function find(Request $request)
    {
        $first = $request->request->get('first');
        $last = $request->request->get('last');
        $guest = $this->guest->find($first, $last);

        $loc = '';
        if (is_null($guest)) {
            $loc = 'not-found';
        }
        else {
            $loc = sprintf('pay/%d', $guest->id());
        }

        return new Response('', 301, [
            'location' => $loc
        ]);
    }

    public function payment($guestId)
    {
        $guest = $this->guest->get($guestId);

        if (is_null($guest)) {
            return new Response('', 301, [
                'location' => '/not-found'
            ]);
        }

        return new Response($this->template->render('pay', [
            'guest' => $guest
        ]));
    }

    public function notFound()
    {
        return new Response($this->template->render('not-invited'));
    }

    public function thanks()
    {
        return new Response($this->template->render('thanks'));
    }
}