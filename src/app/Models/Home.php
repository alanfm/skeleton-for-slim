<?php

namespace App\Models;

use App\Helpers\Bootstrap\Alerts;
use App\Helpers\Bootstrap\Pagination;
use Psr\Http\Message\RequestInterface;
use System\Model;

class Home extends Model
{
    public function __construct($container)
    {
        $table = 'teste';
        parent::__construct($container, $table);
    }

    public function index(RequestInterface $request)
    {
        $this->mercado = 'mercado';
        $this->varejo = 'varejo';
        $this->range = range('a', 'l');
        $this->teste();
        $alert = \App\Helpers\Alerts::get('alert', true);
        $this->alert = Alerts::render($alert->type, $alert->message);
        $this->pagination = Pagination::render(12*12, 6, 'home');

        return $this->data;
    }
}