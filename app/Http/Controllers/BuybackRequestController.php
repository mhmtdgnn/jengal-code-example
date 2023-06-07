<?php

namespace App\Http\Controllers;

use App\Models\BuybackRequest;
use App\Models\QuestionSet;
use App\Models\BuybackRequestLog;
use App\Models\BuybackRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuybackRequestController extends Controller
{
    public function show()
    {
        $title = 'Buyback Talepleri';
        $buybackRequests= BuybackRequest::with('brand','product')->orderBy('id', 'desc')->get();

        return view('buyback.list', compact('buybackRequests', 'title'));
    }

    public function detail($id)
    {
        $title = "Buyback Talep Detayı";
        $buybackRequest = BuybackRequest::with('brand','product')->find($id);

        $questionSet = QuestionSet::find($buybackRequest->selected_set);
        $question = json_decode($questionSet->data);

        $log = BuybackRequestLog::with('status')->where('buyback_request_id', $id)->orderBy('created_at', 'desc')->get();
        $status = BuybackRequestStatus::all();

        return view('buyback.detail', compact('buybackRequest', 'question', 'title', 'log', 'status' ));
    }

    public function buyback_request_log(Request $request)
    {
        $BuybackRequestLog = BuybackRequestLog::create([
            'buyback_request_id' => $request->talep_id,
            'status_id' => $request->talep_status,
            'comment' => $request->status_aciklama
        ]);

        $BuybackRequestLog->save();

        return redirect('/buyback/detail/'.$request->talep_id.'#tab_logs');
    }
}
