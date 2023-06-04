<?php
declare(strict_types=1);

namespace flute;
class Response
{
    public function __construct()
    {
    }

    public static function get()
    {
        
    }

    public function send(array $array)
    {
        echo json_encode($array);
    }
}