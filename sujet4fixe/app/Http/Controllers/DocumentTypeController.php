<?php
namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function index()
    {
        return DocumentType::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:document_types|max:255',
        ]);

        return DocumentType::create($request->all());
    }

    public function show($id)
    {
        return DocumentType::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $document = DocumentType::findOrFail($id);
        $document->update($request->all());
        return $document;
    }

    public function destroy($id)
    {
        return DocumentType::destroy($id);
    }
}