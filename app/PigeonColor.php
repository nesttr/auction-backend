<?php

namespace App;

enum PigeonColor : string
{
    use EnumHelper;
    case WHITE = 'white';
    case BLACK = 'black';
    case BLUE = 'blue';
    case BROWN = 'brown';
    case CREAM = 'cream';
    case CHECKERED = 'checkered';
    case BARRED = 'barred';
    case PLAIN = 'plain';
    case SPECKLED = 'speckled';
    case SILVER = 'silver';
    case LAVENDER = 'lavender';
    case ALBINO = 'albino';
    case OPAL = 'opal';
    case SADDLE = 'saddle';
    case PIED = 'pied';
    case CHAMPAGNE = 'champagne';
    case FAWN = 'fawn';
}
