<?php

namespace App\Models\Repositories;


class TicketlogsRepository extends BaseRepository
{
    public function model() { return 'App\Models\Entities\ticketlogs';  }
    public function getByPaginate($request)
    {
        $sort = $request->sort; $sort = explode('|', $sort);  $sortBy = $sort[0];  $sortDirection = $sort[1];
        $perPage = $request->per_page;
        $search = $request->filter;
       // $ticket_no = $request->input('filter.ticket_no');
        $subticket_no = $request->input('filter.subticket_no');
       // $type = $request->input('filter.type');
        $level = $request->input('filter.level');
        $auser = $request->input('filter.auser');;

        $query = $this->model->select()->active()->orderBy($sortBy, $sortDirection);

        $ticket_no =    trim($search['ticket_no']);
        if ($ticket_no) {   $like = "%{$ticket_no}%"; $query->where('ticket_no', 'LIKE', $like);  }

       // if ($type) {$like = "%{$type}%"; $query->where('ticketlogs.ticket_no', 'LIKE', $like); }
        if ($level) { $like = "%{$level}%"; $query->where('ticketlogs.level', 'LIKE', $like); }
     //   if ($ticket_no) { $like = "{$ticket_no}"; $query->where('ticketlogs.ticket_no', 'LIKE', $like); }
        if ($subticket_no) { $like = "%{$subticket_no}%"; $query->where('ticketlogs.subticket_no', 'LIKE', $like); }
        if ($auser) { $like = "{$auser}"; $query->where('ticketlogs.updated_by', 'LIKE', $like); }


        return $query->paginate($perPage);
    }
}