<?php

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Support\Collection;

class AuthorRepository
{
    public function create(array $data): Author
    {
        return Author::create($data);
    }

    public function createMany(int $researchId, array $authors): Collection
    {
        $created = collect();
        foreach ($authors as $author) {
            $author['research_id'] = $researchId;
            $created->push(Author::create($author));
        }
        return $created;
    }
}