<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function getDocumentTypes(): Collection
    {
        return DocumentType::get();
    }

    public function getOfficeList(): Collection
    {
        return Office::get();
    }

    // TODO: Validation, logging and error message
    public function addNewDocument(Request $request)
    {
        $document = new Document;
        $document->tracking_code = $request->tracking_id;
        $document->title = $request->document_title;
        $document->is_external = $request->is_external;
        $document->document_type_id = $request->document_type;
        $document->originating_office_id = $request->originating_office_id;
        $document->external_office_name = $request->external_office_name;
        $document->current_office_id = Auth::user()->office->id;
        $document->sender_name = $request->sender_name;
        $document->page_count = $request->page_count;
        $document->date_filed = $request->date_filed;
        $document->is_terminal = false;
        $document->remarks = $request->remarks;
        $document->attachment_page_count = $request->attachment_page_count;
        $document->save();
    }


}
