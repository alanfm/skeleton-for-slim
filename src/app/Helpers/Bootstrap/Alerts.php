<?php

namespace App\Helpers\Bootstrap;


use HTMLBuilder\ElementFactory as El;

class Alerts
{
    public static function render($type, $message)
    {
        $alert = El::make('div')->attr('class', ['alert', 'alert-'.$type])
                                                  ->attr('role', ['alert']);
        $alert->value(static::button());
        $alert->value(El::make('h4')->attr('class', ['alert-heading'])->value('Atenção!'));
        $alert->value(El::make('hr'));
        $alert->value(El::make('p')->value($message));

        return $alert->render();
    }

    private static function button()
    {
        return El::make('button')->attr('type', ['button'])
                                       ->attr('class', ['close'])
                                       ->attr('data-dismiss', ['alert'])
                                       ->attr('aria-label', ['Fechar'])
                                       ->value(El::make('span')->attr('aria-hidden', [true])->value('&times;'));
    }
}