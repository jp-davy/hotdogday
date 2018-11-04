<?php

namespace App\Http\Utilities;

class SageWarehouse
{

    protected static $warehouses = [
          "111" => "111",
          "112" => "112",
          "113" => "113",
          "114" => "114",
          "189" => "189",
        ];
    
    public static function all()
    {
        return static::$warehouses;
    }
}
