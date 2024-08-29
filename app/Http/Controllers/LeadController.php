<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function getLeads()
    {
        $leads = Lead::all();
        $leadsCount = $leads->count();
        $statuses = LeadStatus::withCount('leads')
            ->get();

        $leadsCountInStatuses = $statuses->mapWithKeys(function ($status) {
            return [$status->title => $status->leads_count];
        })->toArray();

        return view('leads', ['leads' => $leads, 'statuses' => $statuses, 'leadsCount' => $leadsCount, 'leadsCountInStatuses' => $leadsCountInStatuses]);
    }

    public function updateStatus(int $leadId, int $newStatusId)
    {
        $lead = Lead::find($leadId);

        if (!$lead) {
            return response()->json(['success' => false, 'message' => 'Lead not found.']);
        }

        if (!LeadStatus::where('id', $newStatusId)->exists()) {
            return response()->json(['success' => false, 'message' => 'Status not found.']);
        }

        $lead->status_id = $newStatusId;

        if ($lead->save()) {
            return response()->json(['success' => true, 'message' => 'Status updated']);
        }

        return response()->json(['success' => false, 'message' => 'Status not updated.']);
    }

    public function delete($leadId)
    {
        $lead = Lead::find($leadId);

        if (!$lead) {
            return response()->json(['success' => false, 'message' => 'Lead not found.']);
        }

        if ($lead->delete()) {
            return response()->json(['success' => true, 'message' => 'Lead deleted.']);
        }

        return response()->json(['success' => false, 'message' => 'Lead not deleted.']);
    }

    public function updateLeads(Request $request)
    {
        // Обработка сохранения изменений всех лидов
        // Обновите логику по мере необходимости

        return redirect()->back()->withSuccess('Изменения сохранены.');
    }

}
