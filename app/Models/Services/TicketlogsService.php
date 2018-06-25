<?php

namespace App\Models\Services;


use App\Models\Repositories\TicketlogsRepository;

class TicketlogsService extends BaseService
{
    protected $logRepository;
    public function __construct(TicketlogsRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }
    public function getByPaginate($request)
    {
        return $this->logRepository->getByPaginate($request);
    }
}