<?php

namespace App\Entity\Enum;

enum ReadingStatusEnum : string
{
    case Reading = "Reading";
    case PlanToRead = "Plan to Read";
    case Drop = "Drop";
    case Completed = "Completed";
}
