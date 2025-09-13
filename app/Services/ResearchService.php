<?php

namespace App\Services;

use App\Models\Research;
use App\Repositories\ResearchRepository;
use App\Repositories\AuthorRepository;
use App\Repositories\AttachmentRepository;
use Illuminate\Support\Facades\DB;

class ResearchService
{
    public function __construct(
        protected ResearchRepository $researchRepo,
        protected AuthorRepository $authorRepo,
        protected AttachmentRepository $attachmentRepo
    ) {}

    /**
     * @param array $data  validated research + authors
     * @param array $files array of UploadedFile (attachments)
     */
    public function create(array $data, array $files = []): Research
    {
        return DB::transaction(function () use ($data, $files) {
            // Create research
            $research = $this->researchRepo->create([
                'title'    => $data['title'],
                'abstract' => $data['abstract'] ?? null,
                'keyword'  => $data['keyword'] ?? null,
            ]);

            //  Create authors 
            if (!empty($data['authors']) && is_array($data['authors'])) {
                $this->authorRepo->createMany($research->id, $data['authors']);
            }

            //  Store attachments
            if (!empty($files)) {
                $this->attachmentRepo->storeMany($research->id, $files);
            }

            return $research->load(['authors', 'attachments']);
        });
    }

    public function find(int $id): ?Research
    {
        return $this->researchRepo->find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return $this->researchRepo->paginate($perPage);
    }
}