<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('tokens:delete-expired --force')->dailyAt('00:00');