<?php

namespace App\Models\Repositories;


class TicketlogsRepository extends BaseRepository
{
    public function model() { return 'App\Models\Entities\ticketlogs';  }
    public function getByPaginate($request)
    {
        $sort = $request->sort; $sort = explode('|', $sort);  $sortBy = $sort[0];  $sortDirection = $sort[1];
        $perPage = $request->per_page;
        $search = $request->input('filter.filterText');
        $type = $request->input('filter.type');
        $level = $request->input('filter.level');

        $query = $this->model->select()->active()->orderBy($sortBy, $sortDirection);

        if ($type) {$like = "%{$type}%"; $query->where('ticketlogs.type', 'LIKE', $like); }
        if ($level) { $like = "%{$level}%"; $query->where('ticketlogs.level', 'LIKE', $like); }
        if ($search) 
           {  $like = "%{$search}%";
              $query = $query->where(function ($query) use ($like) 
                 { $query->where('ticketlogs.entity_name', 'LIKE', $like)->orwhere('ticketlogs.function_name', 'LIKE', $like)
                         ->orwhere('ticketlogs.message', 'LIKE', $like);
                 });
           }
        return $query->paginate($perPage);
    }
}