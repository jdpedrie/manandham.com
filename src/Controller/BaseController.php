<?php namespace MH\Controller;

use League\Plates\Engine as Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BaseController implements ControllerInterface
{
    private $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function index(Request $request) : Response
    {
        return new Response($this->template->render('home', [
          'invalidPassword' => (!is_null($request->query->get('invalid'))),
          'alreadyPaid' => (!is_null($request->query->get('alreadyPaid')))
        ]));
    }
}