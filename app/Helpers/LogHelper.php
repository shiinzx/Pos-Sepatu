<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class LogHelper
{
    public static function record($action, $description)
    {
        ActivityLog::create([
            'action' => $action,
            'description' => $description
        ]);
    }
}
