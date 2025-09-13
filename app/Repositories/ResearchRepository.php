<?php

namespace App\Repositories;

use App\Models\Research;

class ResearchRepository
{
    public function create(array $data): Research
    {
        return Research::create($data);
    }

    public function find(int $id): ?Research
    {
        return Research::with(['authors', 'attachments'])->find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Research::with(['authors', 'attachments'])->paginate($perPage);
    }

    public function update(Research $research, array $data): Research
    {
        $research->update($data);
        return $research->fresh(['authors', 'attachments']);
    }

    public function delete(Research $research): void
    {
        $research->delete(); // soft delete
    }
}