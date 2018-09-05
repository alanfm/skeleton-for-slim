<?php

namespace App\Helpers;

use SlimSession\Helper;

class Alerts
{
    private static $session;

    private static function setSession()
    {
        static::$session = new Helper();
    }

    public static function set($type, $message, $session = 'alert')
    {
        if (!isset(static::$session)) {
            static::setSession();
        }

        self::$session->merge($session,['type'=>$type]);

        if ($message) {
            static::$session->merge($session, ['message'=>$message]);
            return;
        }

        static::$session->merge($session, static::parsedMessage($type));
        return;
    }

    private static function parsedMessage($type)
    {
        $msg = [];

        switch ($type) {
            case 'success':
                $msg['message'] = 'Operação realizada com sucesso.';
                break;
            case 'danger':
            case 'warning':
                $msg['message'] = 'Erro ao realizar a operação.';
                break;
        }

        return $msg;
    }

    public static function get($session, $destroy = false)
    {
        if (static::$session->exists($session)) {
            $result = static::$session->get($session);

            if ($destroy){
                static::$session->delete($session);
            }

            return (object) $result;
        }

        return;
    }
}