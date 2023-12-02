<?php

namespace App\Entity\Enum;

enum EmojiEnum : string
{
    case Happiness = '😀';
    case Sad = '😭';
    case Choke = '😱';
    case Love = '😍';
    case Bored = '😑';
    case Fear = '😨';
    case Unknown = '❔';

}