<?php

namespace App;

enum PigeonSize : string
{
    use EnumHelper;
    case SMALL = 'small';
    case MEDIUM = 'medium';
    case LARGE = 'large';
    case EXTRA_LARGE = 'extra_large';
}
