<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Entities\Log;
use App\Models\Entities\ticketlogs;
use App\Models\Services\TicketType5Service;
use App\Models\Services\UserService;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class Tickettype5Controller extends Controller
{
    protected $TicketType5Service; protected $userService; 
    public function __construct( UserService $userService, TicketType5Service $TicketType5Service)
    {   $this->TicketType5Service = $TicketType5Service;   $this->userService = $userService;  }
//------------------------------------------------------------
    public function getTicketType5Table(Request $request)
    {    try {   $user = JWTAuth::parseToken()->authenticate(); 
               // $this->validate($request, $rules);         
                $gett1= $this->TicketType5Service->getTicketType5Table($request);
                return response()->json(['gett1' => $gett1, ]);
             } catch (Exception $e) 
             { return response()->json(['error' => $e->getMessage()], 500); }
    }
//-------------------------------------------------------------
public function addTicketType5Table(Request $request)
{   $rules = [// 'price'  =>  'required', 
    'ticket_no' => 'required', 'user.id' =>'required', 'status_id' =>'required'  ];
    try {    $user = JWTAuth::parseToken()->authenticate();
             $this->validate($request, $rules);
             $gett1 = $this->TicketType5Service->addTicketType5Table($request);
            // $this->TicketType5Service->LogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
             $this->TicketType5Service->TicketLogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
           return response()->json(compact('gett1'));
         } catch (Exception $e) 
        {    return $this->handleValidationException($e, $this->TicketType5Service, __CLASS__ . '::' . __FUNCTION__, Log::LOG_LEVEL_ERROR);
        }
}
public function updateTicketType5(Request $request)
{   $rules = ['id' => 'required', 'ticket_no' => 'required' , 'user.id' =>'required', 'status_id' =>'required'  ];
try {
    $user = JWTAuth::parseToken()->authenticate();
    $this->validate($request, $rules);
    $gett1 = $this->TicketType5Service->updateTicketType5Table($request);
 //   $this->TicketType5Service->LogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
    $this->TicketType5Service->TicketLogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
    return response()->json(compact('gett1'));
} catch (Exception $e) {
    return $this->handleValidationException($e, $this->TicketType5Service, __CLASS__ . '::' . __FUNCTION__, Log::LOG_LEVEL_ERROR);
}
}

//-----------------delete
public function deleteTicketType5(Request $request)
{
    $rules = [ 'id'  =>  'required' ];
    try {  $user = JWTAuth::parseToken()->authenticate();    $this->validate($request, $rules);
           $gett1 = $this->TicketType5Service->deleteTicketType5Table($request);
        //  $this->TicketType5Service->LogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
          $this->TicketType5Service->TicketLogEntity($gett1, 'success', __CLASS__ . '::' .__FUNCTION__);
           return response()->json(compact('gett1'));
        }
    catch (Exception $e)
    { return $this->handleValidationException($e, $this->TicketType5Service, __CLASS__ . '::' . __FUNCTION__, Log::LOG_LEVEL_ERROR);
    }
}

}
