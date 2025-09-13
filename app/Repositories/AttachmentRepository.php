<?php

namespace App\Repositories;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AttachmentRepository
{
    /**
     * Store one file and create DB row.
     */
    public function storeOne(int $researchId, UploadedFile $file): Attachment
    {
        // store in storage/app/public/research_docs
        $path = $file->store('research_docs', 'public');
        return Attachment::create([
            'research_id' => $researchId,
            'doc_path'    => $path,
        ]);
    }

    /**
     * Store many files; returns array of Attachment models.
     */
    public function storeMany(int $researchId, array $files): array
    {
        $items = [];
        foreach ($files as $file) {
            $items[] = $this->storeOne($researchId, $file);
        }
        return $items;
    }
}