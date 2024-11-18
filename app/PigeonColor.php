<?php

namespace App;

enum PigeonColor : string
{
    case WHITE = 'white';
    case BLACK = 'black';
    case BLUE = 'blue';
    case BROWN = 'brown';
    case CREAM = 'cream';

    // Patterns
    case CHECKERED = 'checkered';
    case BARRED = 'barred';
    case PLAIN = 'plain';
    case SPECKLED = 'speckled';

    // Special Colors
    case SILVER = 'silver';
    case LAVENDER = 'lavender';
    case ALBINO = 'albino';
    case OPAL = 'opal';
    case SADDLE = 'saddle';

    // Breeder-Specific Colors
    case PIED = 'pied';
    case CHAMPAGNE = 'champagne';
    case FAWN = 'fawn';
}
