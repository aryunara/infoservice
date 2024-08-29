<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use App\Models\LeadStatus;
use Exception;

class MainController
{
    public function getMain()
    {
        return view('main');
    }

    /**
     * @throws Exception
     */
    public function createLead(LeadRequest $request)
    {
        $validated = $request->validated();

        $statusId = LeadStatus::where('code', 'new')
            ->value('id');

        if (!$statusId) {
            return redirect("main-board")->with('Статус не найден. Запустите LeadStatusSeeder.');
        }

        Lead::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'status_id' => $statusId,
            'text' => $validated['text'],
        ]);

        return redirect("main-board")->withSuccess('Ваше обращение создано! Для просмотра обращений войдите в аккаунт.');
    }

    public function getBoard()
    {
        return view('main_board');
    }
}
