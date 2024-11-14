<?php

namespace App\Enums;

enum DaysEnum:int
{
    case Sunday = 0;// in spanish Domingo
    case Monday = 1;
    case Tuesday = 2;
    case Wednesday = 3;
    case Thursday = 4;
    case Friday = 5;
    case Saturday = 6;
    
    public static function toArray(): array
    {
        return [
            'Sunday' => self::Sunday->value,
            'Monday' => self::Monday->value,
            'Tuesday' => self::Tuesday->value,
            'Wednesday' => self::Wednesday->value,
            'Thursday' => self::Thursday->value,
            'Friday' => self::Friday->value,
            'Saturday' => self::Saturday->value,
        ];
    }
}
