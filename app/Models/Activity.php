<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperActivity
 */
class Activity extends \Spatie\Activitylog\Models\Activity
{
    use HasFactory, SoftDeletes;
}
