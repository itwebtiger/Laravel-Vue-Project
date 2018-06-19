<?php

namespace App\Models\Services;


use App\Models\Entities\Log;
use App\Models\Entities\ticketlogs;

Abstract class BaseService
{
    public function LogEntity($entity, $msg,  $funcName, $level = Log::LOG_LEVEL_NORMAL)
    {
        Log::LogEntity($entity, $msg,  $funcName, $level);
    }
    public function TicketLogEntity($entity, $msg, $funcName, $level = ticketlogs::LOG_LEVEL_NORMAL)
    {
        ticketlogs::TicketLogEntity($entity, $msg, $funcName, $level);
    }

}