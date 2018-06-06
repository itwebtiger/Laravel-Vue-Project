<?php
namespace App\Models\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ticketlogs extends BaseModel
{
    const ACTION_TYPE_USER = 'USER_ACTION';
    const ACTION_TYPE_SYSTEM = 'SYSTEM_ACTION';

    const LOG_LEVEL_NORMAL = 'NORMAL';
    const LOG_LEVEL_ERROR = 'ERROR';
    const LOG_LEVEL_WARNING = 'WARNING';

    protected $table = "ticketlogs";

    /**
     * mass assignment
     * @var array
     */
    protected $fillable = ['type', 'message', 'entity_name', 'entity_id', 'function_name', 'level',
            'ticket_no', 'subticket_no', 'laa' , //'saa'
    ];

    public static function TicketLogEntity($entity, $msg, $funcName, $level = Log::LOG_LEVEL_NORMAL)
    {
        $user = Auth::user();
        if ($user instanceof User) {  $type = ticketlogs::ACTION_TYPE_USER; } 
        else {  $type = ticketlogs::ACTION_TYPE_SYSTEM;  }
        if (is_array($entity)) 
        {   foreach ($entity as $item) 
            {   ticketlogs::create([
                    'type' => $type,
                    'message' => $msg,
                    'entity_name' => $item ? get_class($item) : get_called_class(),
                    'entity_id' => $item ? $item->id : '',
                    'ticket_no' => $item ? $item->ticket_no : '',
                    'subticket_no' => "sdfsdf",
                    'laa' => $item ? $item->comment : '',
                    'function_name' => $funcName,
                    'level' => $level
                ]);
            }
        } else {
            ticketlogs::create([
                'type' => $type,
                'message' => $msg,
                'entity_name' => $entity ? get_class($entity) : get_called_class(),
                'entity_id' => $entity ? $entity->id : '',
                'laa' => $entity ? $entity : '',
                'subticket_no' => $entity ? $entity->id : '',
                'ticket_no' => $entity ? $entity->ticket_no : '',
                'function_name' => $funcName,
                //'saa' => $entity ? $entity->updated_by->id : '',
                'level' => $level
            ]);
        }
    }
}