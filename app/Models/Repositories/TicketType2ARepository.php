<?php

namespace App\Models\Repositories;

use App\Models\Entities\ResourceType;
use App\Models\Entities\tickettype2;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\SMS\Facades\SMS;

class TicketType2ARepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Entities\tickettype2';
    }
    public function getTicketType1Table($request)  //not used
    {
        $qi = $request->input('ticket_no');
        return $this->model->where('active', 1)->where('ticket_no', $qi)->get()->keyBy('id')->toArray();

    }

    public function addTicketType2ATable($request)
    {
        $tickettype1 = new tickettype2();
        $tickettype1->ticket_no = $request->input('ticket_no');
        $tickettype1->amount = $request->input('price');
        $tickettype1->aa = $request->input('status_id');
        $tickettype1->comment = $request->input('comment');
        $tickettype1->aaa = $request->input('reason');
        $tickettype1->bb = $request->input('user.id'); //managed user id
        $tickettype1->cc = $request->input('group.id');   //managed user group
        $tickettype1->save();
        try {
            Mail::raw($request, function ($message) use ($request) {
                $message->from('OMS@dowell.com.au', 'OMS');
                $message->to($request->input('approvinguseremail'));
                $message->cc('manoj.mishra@dowell.com.au');
                $tktno = $request->input('ticket_no');
                $status = $request->input('sdastatus');
                $comments = $request->input('comment');
                $message->subject("OMS: New Credit Note added to Ticket No-$tktno");
                $message->setBody("New Credit Note has been added to Ticket No- $tktno, and assigned to you for approval.\n\n STATUS:$status\n\n Comments:$comments\n\n Please access server (http://10.102.108.10/) for further actions\n\nIts an automatically generated email, please do not reply.");
            });
        } catch (\Exception $ex) {
           // do nothing
        }
        return $tickettype1;
    }


    public function updateTicketType2ATable($request)
    {
        $ttt = $this->model->findOrFail($request->input('id'));  
     //   $ttt->price = $request->input('price');
        $ttt->ticket_no = $request->input('ticket_no');
        $ttt->amount = $request->input('price');
        $ttt->aa = $request->input('status_id');
        $ttt->comment = $request->input('comment');
        $ttt->aaa = $request->input('reason');
        $ttt->bb = $request->input('user.id'); //managed user id
        $ttt->cc = $request->input('group.id');   //managed user group
        $ttt->comment = $request->input('comment');

        $ttt->save();
        try {
            Mail::raw($request, function ($message) use ($request) {
                $message->from('OMS@dowell.com.au', 'OMS');
                $message->to($request->input('approvinguseremail'));
                $message->cc('manoj.mishra@dowell.com.au');
                $tktno = $request->input('ticket_no');
                $status = $request->input('sdastatus');
                $comments = $request->input('comment');
                $message->subject("OMS:Credit Note changed in Ticket No-$tktno");
                $message->setBody("Credit Note has been changed in Ticket No- $tktno.\n\n Present Status:$status\n\n Comments:$comments\n\nPlease access server (http://10.102.108.10/) for further actions \n\nIts an automatically generated email, please do not reply.");

            });
        } catch (\Exception $ex) {
           // do nothing
        }
        return $ttt;
    }


    public function deleteTicketType2ATable($request)
    {
        $testb1 = $this->model->findOrFail($request->input('id'));
        $testb1->active = 0;
        $testb1->save();
        return $testb1;
    }


}