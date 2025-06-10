<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log an activity
     *
     * @param string $action CREATE, UPDATE, DELETE, LOGIN, etc
     * @param string $module Module name (DailyActivity, User, etc)
     * @param string $description Description of the activity
     * @param array|null $oldData Data before change
     * @param array|null $newData Data after change
     * @return ActivityLog
     */
    public static function log($action, $module, $description, $oldData = null, $newData = null)
    {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }

    /**
     * Log a create activity
     */
    public static function logCreate($module, $description, $newData = null)
    {
        return self::log('CREATE', $module, $description, null, $newData);
    }

    /**
     * Log an update activity
     */
    public static function logUpdate($module, $description, $oldData = null, $newData = null)
    {
        return self::log('UPDATE', $module, $description, $oldData, $newData);
    }

    /**
     * Log a delete activity
     */
    public static function logDelete($module, $description, $oldData = null)
    {
        return self::log('DELETE', $module, $description, $oldData, null);
    }

    /**
     * Log a login activity
     */
    public static function logLogin($description)
    {
        return self::log('LOGIN', 'Auth', $description);
    }

    /**
     * Log a logout activity
     */
    public static function logLogout($description)
    {
        return self::log('LOGOUT', 'Auth', $description);
    }
} 