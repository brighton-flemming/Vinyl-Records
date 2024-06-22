<?php

namespace App\Service;

use App\Repository\VinylRepository;

class IdManager
{
    private $repository;

    public function __construct(VinylRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getNextId(): int
    {
        $lastId = $this->repository->findMaxId();
        return $lastId + 1;
    }
}
