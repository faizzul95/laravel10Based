<?php

namespace App\Services\Generals\Constants;

final class Salutation {

    public const Mr = 1;
    public const Mrs = 2;
    public const Dr = 3;
    public const Tansri = 4;
    public const Puansri = 5;
    public const Dato = 6;
    public const Datuk = 7;
    public const Datosri = 8;
    public const Datin = 9;
    public const Ms = 10;
    public const Madam = 11;

    public const LIST = [
        1 => 'Mr.',
        2 => 'Mrs.',
        3 => 'Dr.',
        4 => 'Tan Sri',
        5 => 'Puan Sri',
        6 => 'Dato\'',
        7 => 'Datuk',
        8 => 'Dato\' Seri',
        9 => 'Datin',
        10 => 'Ms.',
        11 => 'Madam'
    ];
    
}