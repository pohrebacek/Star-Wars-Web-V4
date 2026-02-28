<?php

namespace App\Model\Media;

enum MediaStatus: string
{
    case PLANNED = "planned";
    case IN_PROGRESS = "in_progress";
    case COMPLETED = "completed";
    case ON_HOLD = "on_hold";
    case DROPPED = "dropped";
    case REVISITING = "revisiting";
}
