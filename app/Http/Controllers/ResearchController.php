<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResearchService;
use Illuminate\Validation\Rule;

class ResearchController extends Controller
{
    public function __construct(private ResearchService $service) {}

    public function index()
    {
        return response()->json($this->service->paginate(15));
    }

    public function show(int $id)
    {
        $item = $this->service->find($id);
        if (!$item) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function store(Request $request)
    {
        // Validation:
        $validated = $request->validate([
            'title'                 => ['required', 'string', 'max:255'],
            'abstract'              => ['nullable', 'string'],
            'keyword'               => ['nullable', 'string', 'max:255'],

            // authors, if present, validate each:
            'authors'                       => ['nullable', 'array'],
            'authors.*.f_name'              => ['required_with:authors', 'string', 'max:100'],
            'authors.*.l_name'              => ['required_with:authors', 'string', 'max:100'],
            'authors.*.email'               => ['nullable', 'email', 'max:255'],
            'authors.*.altr_email'          => ['nullable', 'email', 'max:255'],
            'authors.*.mobile'              => ['nullable', 'string', 'max:30'],
            'authors.*.affinition'          => ['nullable', 'string', 'max:255'],

            // attachments[] are files
            'attachments'           => ['nullable', 'array'],
            'attachments.*'         => ['file', 'mimes:pdf,doc,docx,png,jpg,jpeg', 'max:5120'], 
        ]);

        // Get uploaded files array
        $files = $request->file('attachments', []); // returns array of UploadedFile

        $created = $this->service->create($validated, $files);

        return response()->json($created, 201);
    }
}
