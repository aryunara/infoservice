<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function getLeads()
    {
        $leads = Lead::all();
        $leadsCount = $leads->count();
        $statuses = LeadStatus::withCount('leads')
            ->get();

        $leadsCountInStatuses = $statuses->mapWithKeys(function ($status) {
            return [
                $status->title => $status->leads_count
            ];
        })->toArray();

        return view('leads', [
            'leads' => $leads,
            'statuses' => $statuses,
            'leadsCount' => $leadsCount,
            'leadsCountInStatuses' => $leadsCountInStatuses
        ]);
    }

    public function updateStatus(int $leadId, int $newStatusId)
    {
        $lead = Lead::find($leadId);

        if (!$lead) {
            return response()->json(['success' => false, 'message' => 'Лид не найден.']);
        }

        if (!LeadStatus::where('id', $newStatusId)->exists()) {
            return response()->json(['success' => false, 'message' => 'Статус не найден.']);
        }

        $lead->status_id = $newStatusId;

        if ($lead->save()) {
            return response()->json(['success' => true, 'message' => 'Статус обновлен.']);
        }

        return response()->json(['success' => false, 'message' => 'Статус не обновлен.']);
    }

    public function delete(int $leadId)
    {
        $lead = Lead::find($leadId);

        if (!$lead) {
            return response()->json(['success' => false, 'message' => 'Лид не найден.']);
        }

        if ($lead->delete()) {
            return response()->json(['success' => true, 'message' => 'Лид удален.']);
        }

        return response()->json(['success' => false, 'message' => 'Лид не удален.']);
    }

    public function updateLeads(Request $request)
    {
        $leads = $request->input();

        try {
            DB::transaction(function () use ($leads) {
                foreach ($leads as $leadData) {
                    $lead = Lead::find($leadData['id']);

                    if (!$lead) {
                        throw new Exception('Lead not found');
                    }

                    $lead->name = $leadData['name'];
                    $lead->surname = $leadData['surname'];
                    $lead->email = $leadData['email'];
                    $lead->phone = $leadData['phone'];
                    $lead->save();
                }
            }, 2);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('Error updating leads: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
