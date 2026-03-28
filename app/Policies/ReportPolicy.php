<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Report;

class ReportPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function reportAnswer(User $user, Report $report = null)
    {
        # code...
        return $user->isExpert();
    }

    public function reportQuestion(User $user, Report $report = null)
    {
        # code...
        return true;
    }

    public function resolve(User $user, Report $report)
    {
        # code...
        return $user->isAdmin();
    }
}
