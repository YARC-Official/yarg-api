<?php

namespace App\Enum\Source;

enum GameTypeEnum: string
{
    case GuitarHero = 'gh';
    case RockBand   = 'rb';
    case Charter    = 'charter';
    case Custom     = 'custom';
    case Game       = 'game';
}
