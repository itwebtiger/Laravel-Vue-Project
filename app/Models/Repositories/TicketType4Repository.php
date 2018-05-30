<?php

namespace App\Models\Repositories;

use App\Models\Entities\ResourceType;
use App\Models\Entities\tickettype4;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\SMS\Facades\SMS;

class TicketType4Repository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Entities\tickettype4';
    }
    public function getTicketType4Table($request) //not used
    {
        $qi = $request->input('ticket_no');
        return $this->model->where('active', 1)->where('ticket_no', $qi)->get()->keyBy('id')->toArray();

    }

    public function addTicketType4Table($request)
    {
        $tickettype1 = new tickettype4();
        $tickettype1->ticket_no = $request->input('ticket_no');
        $tickettype1->amount = $request->input('price');
        $tickettype1->aa = $request->input('status_id');
        $tickettype1->comment = $request->input('comment');
        $tickettype1->aaa = $request->input('allitems2'); //all items
        $tickettype1->bb = $request->input('user.id'); //managed user id
        $tickettype1->cc = $request->input('group.id');   //managed user group
        $tickettype1->bbb = $request->input('item1_id');

        $tickettype1->save();
        try {
            Mail::raw($request, function ($message) use ($request) {
                $message->from('OMS@dowell.com.au', 'OMS');
                $message->to($request->input('approvinguseremail'));
                $message->cc('manoj.mishra@dowell.com.au');
                $tktno = $request->input('ticket_no');
                $status = $request->input('sdastatus');
                $comments = $request->input('comment');
                $message->subject("OMS: New Pickup Docket added to Ticket No-$tktno");
                $message->setBody("New Pickup Docket has been added to Ticket No- $tktno, and assigned to you for approval.\n\n STATUS:$status\n\n Comments:$comments\n\n Please access server (http://10.102.108.10/) for further actions\n\nIts an automatically generated email, please do not reply.");
            });
        } catch (\Exception $ex) {
           // do nothing
        }

        return $tickettype1;
    }


    public function updateTicketType4Table($request)
    {
        $tickettype1 = $this->model->findOrFail($request->input('id'));
        $tickettype1->ticket_no = $request->input('ticket_no');
        $tickettype1->amount = $request->input('price');
        $tickettype1->aa = $request->input('status_id');
        $tickettype1->comment = $request->input('comment');
        $tickettype1->aaa = $request->input('allitems2'); //all items
        $tickettype1->bb = $request->input('user.id'); //managed user id
        $tickettype1->cc = $request->input('group.id');   //managed user group
        $tickettype1->bbb = $request->input('item1_id');

        $tickettype1->save();
        try {
            Mail::raw($request, function ($message) use ($request) {
                $message->from('OMS@dowell.com.au', 'OMS');
                $message->to($request->input('approvinguseremail'));
                $message->cc('manoj.mishra@dowell.com.au');
                $tktno = $request->input('ticket_no');
                $status = $request->input('sdastatus');
                $comments = $request->input('comment');
                $message->subject("OMS:Pickup Docket changed in Ticket No-$tktno");
                $message->setBody("Pickup Docket has been changed in Ticket No- $tktno.\n\n Present Status:$status\n\n Comments:$comments\n\nPlease access server (http://10.102.108.10/) for further actions \n\nIts an automatically generated email, please do not reply.");

            });
        } catch (\Exception $ex) {
           // do nothing
        }
        return $tickettype1;
    }


    public function deleteTicketType4Table($request)
    {
        $testb1 = $this->model->findOrFail($request->input('id'));
        $testb1->active = 0;
        $testb1->save();
        return $testb1;
    }





}