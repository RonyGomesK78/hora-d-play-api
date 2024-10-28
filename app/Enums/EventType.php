<?php

namespace App\Enums;

enum EventType: string
{
    case INITIAL_WHISTLE = 'initial whistle';
    case HALF_TIME = 'half-time';
    case FINAL_WHISTLE = 'final whistle';
    case GOAL = 'goal';
    case ASSIST = 'assist';
    case SUBBING_OFF = 'subbing off';
    case SUBBING_IN = 'subbing in';
    case FOUL = 'foul';
    case RED_CARD = 'red card';
    case YELLOW_CARD = 'yellow card';
    case INJURY = 'injury';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
