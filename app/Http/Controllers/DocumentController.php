<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use DB;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\TrackingRecord;

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

    public function getAllActiveDocuments(): Collection
    {
        return Document::where('current_office_id', Auth::user()->office_id)
            ->where('is_terminal', false)
            ->orderBy('date_filed', 'desc')
            ->get();
    }

    public function addNewDocument(Request $request): Array
    {
        DB::beginTransaction();
        try {
            $document = new Document;
            $document->tracking_code = $request->tracking_id;
            $document->title = strtoupper($request->document_title);
            $document->is_external = $request->is_external;
            $document->document_type_id = $request->document_type;
            $document->originating_office = $request->originating_office;
            $document->current_office_id = Auth::user()->office->id;
            $document->sender_name = $request->sender_name;
            $document->page_count = $request->page_count;
            $document->date_filed = Carbon::createFromFormat('Y-m-d H:i', $request->date_filed.' '.$request->time_filed);
            $document->is_terminal = false;
            $document->remarks = $request->remarks;
            $document->attachment_page_count = $request->attachment_page_count;
            $document->save();
            $document_log = new Log;
            $document_log->user_id = Auth::user()->id;
            $document_log->action = "ADD";
            $document_log->table_name = 'documents';
            $document_log->item_id = $document->id;
            $document_log->new_values = json_encode($document);
            $document_log->save();
            $datetime = Carbon::now();
            $tracking_record = new TrackingRecord;
            $tracking_record->document_id = $document->id;
            $tracking_record->actions = 10;
            $tracking_record->status = 20;
            $tracking_record->touched_by = Auth::user()->id;
            $tracking_record->last_touched = Carbon::createFromFormat('Y-m-d H:i', $request->date_filed.' '.$request->time_filed);
            $tracking_record->remarks = 'generated by document creation';
            $tracking_record->save();
            $tracking_log = new Log;
            $tracking_log->user_id = Auth::user()->id;
            $tracking_log->action = "ADD";
            $tracking_log->table_name = 'tracking_records';
            $tracking_log->item_id = $tracking_record->id;
            $tracking_log->new_values = json_encode($tracking_record);
            $tracking_log->save();
        } catch(ValidationException $error) {
            DB::rollback();
            throw $error;
        } catch(\Exception $error) {
            DB::rollback();
            throw $error;
        }
        DB::commit();
        return [$document, $tracking_record];
    }
}
