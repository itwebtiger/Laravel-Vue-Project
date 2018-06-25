<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entities\Log;
use App\Models\Entities\ticketlogs;
use App\Models\Services\TicketType4Service;
use App\Models\Services\UserService;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class Tickettype4Controller extends Controller
{
    protected $TicketType4Service; protected $userService; 
    public function __construct( UserService $userService, TicketType4Service $TicketType4Service)
    {   $this->TicketType4Service = $TicketType4Service;   $this->userService = $userService;  }
//------------------------------------------------------------
    public function getTicketType4Table(Request $request)
    {    try {   $user = JWTAuth::parseToken()->authenticate(); 
               // $this->validate($request, $rules);         
                $gett1= $this->TicketType4Service->getTicketType4Table($request);
                return response()->json(['gett1' => $gett1, ]);
             } catch (Exception $e) 
             { return response()->json(['error' => $e->getMessage()], 500); }
    }
//-------------------------------------------------------------
public function addTicketType4Table(Request $request)
{   $rules = [// 'price'  =>  'required', 
    'ticket_no' => 'required' , 'user.id' =>'required', 'status_id' =>'required'  ];
    try {    $user = JWTAuth::parseToken()->authenticate();
             $this->validate($request, $rules);
             $gett1 = $this->TicketType4Service->addTicketType4Table($request);
           //  $this->TicketType4Service->LogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
             $this->TicketType4Service->TicketLogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
           return response()->json(compact('gett1'));
        } catch (Exception $e) 
        {    return $this->handleValidationException($e, $this->TicketType4Service, __CLASS__ . '::' . __FUNCTION__, Log::LOG_LEVEL_ERROR);
        }
}
public function updateTicketType4(Request $request)
{   $rules = ['id' => 'required', 'ticket_no' => 'required', 'user.id' =>'required', 'status_id' =>'required'  ];
try {
    $user = JWTAuth::parseToken()->authenticate();
    $this->validate($request, $rules);
    $gett1 = $this->TicketType4Service->updateTicketType4Table($request);
  //  $this->TicketType4Service->LogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
    $this->TicketType4Service->TicketLogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
    return response()->json(compact('gett1'));
} catch (Exception $e) {
    return $this->handleValidationException($e, $this->TicketType4Service, __CLASS__ . '::' . __FUNCTION__, Log::LOG_LEVEL_ERROR);
}
}

public function deleteTicketType4(Request $request)
{
    $rules = [ 'id'  =>  'required' ];
    try {  $user = JWTAuth::parseToken()->authenticate();    $this->validate($request, $rules);
           $gett1 = $this->TicketType4Service->deleteTicketType4Table($request);
         // $this->TicketType4Service->LogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
          $this->TicketType4Service->TicketLogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
           return response()->json(compact('gett1'));
        }
    catch (Exception $e)
    { return $this->handleValidationException($e, $this->TicketType4Service, __CLASS__ . '::' . __FUNCTION__, Log::LOG_LEVEL_ERROR);
    }
}
//------------------------------
}
