<?php

namespace App\Enum;

enum AssignmentRequestStatus: string
{
    case Pending = 'pending';
    case Scheduled = 'scheduled';
}
