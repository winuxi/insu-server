<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Spatie\Activitylog\Models\Activity as ActivityModel;

class Activity extends ActivityModel
{
    use BelongsToTenant;
}
