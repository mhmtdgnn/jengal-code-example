<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityAssignment;
use App\Models\ActivityCall;
use App\Models\ActivityCase;
use App\Models\ActivityChannel;
use App\Models\ActivityLog;
use App\Models\ActivitySubject;
use App\Models\Consumer;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    private $key = "K30adddf5-f819-4500-8350-2f8c9ad82d4f";

    public function index()
    {
        $title = "Aktivite Yönetimi";
        $verimorActive = true;
        $activityChannels = ActivityChannel::get();
        $subjects = ActivitySubject::get();
        $cases = ActivityCase::whereNull('parent_id')->get();
        $users = User::get();

        return view('cm.activity-management', compact('title', 'verimorActive', 'activityChannels', 'users', 'cases', 'subjects'));
    }

    public function activityDetail(Request $request)
    {
        if (isset($request->activity_id)) {
            Session::flash('activity_id', $request->activity_id);
        }
        if (isset($request->consumer_id)) {
            Session::flash('consumer_id', $request->consumer_id);
        }

        return redirect()->route('cm.activityManagement');
    }

    /**
     * Verimor Web Telefonu Dahili Token
     *
     * @return void
     */
    private function getVerimorToken(string $extension_number)
    {
        $postFields = [
            "key"   => $this->key,
            "extension" => $extension_number
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.bulutsantralim.com/webphone_tokens',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    /**
     * Verimor Popup View
     *
     * @return void
     */
    public function verimor()
    {
        $token = $this->getVerimorToken(Auth::user()->verimor_extension_number);

        return view('cm.verimor', compact('token'));
    }

    /**
     * Verimor Çağrı Başlat
     * https://github.com/verimor/Bulutsantralim-API/blob/master/begin_call.md
     *
     * @param Request $request
     * @return void
     */
    public function startCall(Request $request)
    {
        $parameters = [
            "key" => $this->key,
            "extension" => 1019,
            "destination" => $request->phone
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(

            CURLOPT_URL => 'http://api.bulutsantralim.com/originate?' . http_build_query($parameters),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',

        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
   
    /**
     * Verimor Çağrı Sonlandır
     * https://github.com/verimor/Bulutsantralim-API/blob/master/hangup_call.md
     * 
     * @param Request $request
     * @return void
     */
    public function closeCall(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(

            CURLOPT_URL => 'http://api.bulutsantralim.com/hangup/' . $request->uuid . '?key=' . $this->key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',

        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    /**
     * AJAX - Search Consumers by Phone Number
     *
     * @param Request $request
     * @return void
     */
    public function searchConsumers(Request $request)
    {
        $consumers = Consumer::where('phone', preg_replace('/[^0-9]/', '', $request->phone))->get();

        return $consumers;
    }
    
    /**
     * AJAX - Search Consumers by Name or Email
     *
     * @param Request $request
     * @return void
     */
    public function searchConsumersWithText(Request $request)
    {
        $seachedText = preg_replace('/\s+/', '', $request->text);

        $consumers = DB::table(DB::raw("(SELECT 
            id,
            email,
            phone,
            concat(firstName, ' ', lastName) AS fullNameText,
            concat(firstName, lastName) AS fullName
            FROM consumers) AS consumers"))
            ->where('fullName', 'like', '%' . $seachedText . '%')
            ->orWhere('email', 'like', '%' . $seachedText . '%')
            ->get();

        return $consumers;
    }

    /**
     * AJAX - Get User Activities
     *
     * @param Request $request
     * @return void
     */
    public function getActivities(Request $request)
    {
        $consumer = Consumer::find($request->consumer_id);
        $activities = Activity::select(
                'activities.id AS id',
                'activities.durum AS activity_open',
                'activities.hissiyat AS activity_sense',
                'asu.name AS activity_subject', 
                'ach.name AS activity_channel', 
                'aca.name AS activity_case',
                'activities.created_at AS created_at')
            ->leftJoin('activity_subjects AS asu', 'asu.id', '=', 'activities.tip')
            ->leftJoin('activity_channels AS ach', 'ach.id', '=', 'activities.kanal_id')
            ->leftJoin('activity_cases AS aca', 'aca.id', '=', 'activities.case_id')
            ->where('activities.musteri', $request->consumer_id)
            ->orderBy('activities.id', 'desc')
            ->limit(isset($request->limit) ? $request->limit : 100)
            ->get();

        $return['consumer'] = $consumer;
        $return['consumer_acitivities'] = $activities;

        return $return;
    }

    /**
     * AJAX - Get User Activity Details
     *
     * @param Request $request
     * @return void
     */
    public function getActivity(Request $request)
    {
        $activity = Activity::select(
            'activities.id AS id', 
            'u.name AS activity_agent',
            'activities.durum AS activity_open',
            'activities.hissiyat AS activity_sense',
            'activities.yon AS activity_direction',
            'activities.tip AS activity_subject_id',
            'activities.kanal_id AS activity_channel_id',
            'asu.name AS activity_subject', 
            'ach.name AS activity_channel',
            'aca.name AS activity_case',
            'activities.not AS activity_note',
            'activities.created_at AS created_at')
            ->leftJoin('activity_subjects AS asu', 'asu.id', '=', 'activities.tip')
            ->leftJoin('activity_channels AS ach', 'ach.id', '=', 'activities.kanal_id')
            ->leftJoin('activity_cases AS aca', 'aca.id', '=', 'activities.case_id')
            ->leftJoin('users AS u', 'u.id', '=', 'activities.sorumlu')
            ->find($request->activity_id);

        $activityCalls = ActivityCall::select(
            'activity_calls.yon AS call_direction',
            'u.name AS call_agent',
            'activity_calls.not AS call_note',
            'activity_calls.hissiyat AS call_sense',
            'ac.name AS call_channel',
            'activity_calls.arayan AS caller_different',
            'activity_calls.created_at AS created_at',
            )
            ->leftJoin('activity_channels AS ac', 'ac.id', '=', 'activity_calls.kanal_id')
            ->leftJoin('users AS u', 'u.id', '=', 'activity_calls.sorumlu')
            ->where('aktivite_id', $request->activity_id )
            ->get();
        $activityAssignments = ActivityAssignment::select(
            'uf.name AS assignment_from_user',
            'ut.name AS assignment_to_user',
            'activity_assignments.note AS assignment_note',
            'activity_assignments.created_at AS created_at'
            )
            ->leftJoin('users AS uf', 'uf.id', '=', 'activity_assignments.from_user_id')
            ->leftJoin('users AS ut', 'ut.id', '=', 'activity_assignments.to_user_id')
            ->where('aktivite_id', $request->activity_id )
            ->get();
        $activityLogs = ActivityLog::where('activity_id', $request->activity_id )->get();

        $return['activity'] = $activity;
        $return['activity_calls'] = $activityCalls;
        $return['activity_assignments'] = $activityAssignments;
        $return['activity_logs'] = $activityLogs;

        return $return;
    }

    /**
     * Ajax - Activity Add Call
     *
     * @param Request $request
     * @return void
     */
    public function addCall(Request $request)
    {
        $data = [
            'aktivite_id'   => $request->activity_id,
            'kanal_id'      => $request->call_channel,
            'yon'           => $request->call_direction == 'inbound' ? 0 : 1,
            'hissiyat'      => $request->call_sense,
            'sorumlu'       => Auth::user()->id,
            'not'           => $request->call_note
        ];
    
        if (!empty($request->call_different_caller)) {
            $data['arayan'] = $request->call_different_caller;
        }

        try {
            $insert = ActivityCall::create($data);

            if ($insert) {
                ActivityLog::create([
                    'user_id'       => Auth::user()->id,
                    'activity_id'   => $request->activity_id,
                    'type_key'      => 'call',
                    'description'   => 'Çağrı kaydı eklendi.'
                ]);
            }
        } catch (\Throwable $th) {
            return $th;
        }

        return $insert;
    }
    
    /**
     * Ajax - Activity Add Assignment
     *
     * @param Request $request
     * @return void
     */
    public function addAssignment(Request $request)
    {
        $data = [
            'aktivite_id'   => $request->activity_id,
            'from_user_id'  => Auth::user()->id,
            'to_user_id'    => $request->assigned_user,
            'note'          => $request->assignment_note
        ];

        try {
            $insert = ActivityAssignment::create($data);

            if ($insert) {
                ActivityLog::create([
                    'user_id'       => Auth::user()->id,
                    'activity_id'   => $request->activity_id,
                    'type_key'      => 'assignment',
                    'description'   => 'Yönlendirme yapıldı.'
                ]);
            }
            
        } catch (\Throwable $th) {
            return $th;
        }

        return $insert;
    }

    /**
     * Ajax - Activity Completed
     *
     * @param Request $request
     * @return void
     */
    public function activityCompleted(Request $request)
    {
        try {
            $update = Activity::where('id',$request->activity_id)->update(['durum' => 0]);

            if ($update) {
                ActivityLog::create([
                    'user_id'       => Auth::user()->id,
                    'activity_id'   => $request->activity_id,
                    'type_key'      => 'end',
                    'description'   => 'Aktivite sonlandırıldı.'
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $update;
    }

    /**
     * Ajax - Get Cases By Parent ID
     *
     * @param Request $request
     * @return void
     */
    public function getSubCases(Request $request)
    {
        $cases = ActivityCase::where('parent_id', $request->parent_id)->get();

        return $cases;
    }

    /**
     * Ajax - Create New Activity
     *
     * @param Request $request
     * @return void
     */
    public function createActivity(Request $request)
    {
        try {
            $insert =  Activity::create([
                'status'    => 1000,
                'case_id'   => $request->activity_case,
                'kanal_id'  => $request->activity_channel,
                'tip'       => 1,
                'yon'       => $request->activity_direction == 'inbound' ? 0 : 1,
                'hissiyat'  => $request->activity_sense,
                'sorumlu'   => Auth::user()->id,
                'durum'     => 1,
                'musteri'   => $request->consumer_id,
                'not'       => $request->activity_note,
                'siparis_numarasi' => $request->order_number,
            ]);
            if ($insert) {
                ActivityLog::create([
                    'user_id'       => Auth::user()->id,
                    'activity_id'   => $insert->id,
                    'type_key'      => 'start',
                    'description'   => 'Aktivite oluşturuldu.'
                ]);

                $callData = new Request();
                $callData->activity_id = $insert->id;
                $callData->call_channel = $request->activity_channel;
                $callData->call_direction = $request->activity_direction == 'inbound' ? 0 : 1;
                $callData->call_sense = $request->activity_sense;
                $callData->call_note = $request->activity_note;

                $this->addCall($callData);
                
                if (isset($request->activity_close) && $request->activity_close) {
                    $complatedData = new Request();
                    $complatedData->activity_id = $insert->id;
                    $this->activityCompleted($complatedData);
                }
                if (isset($request->add_assignment)) {
                    $assignedData = new Request();
                    $assignedData->activity_id = $insert->id;
                    $assignedData->assigned_user = $request->assigned_user;
                    $assignedData->assignment_note = $request->assignment_note;

                    $this->addAssignment($assignedData);
                }
            }
        } catch (\Throwable $th) {
            return $th;
        }

        return $insert;
    }

    /**
     * Ajax - Update New Activity
     *
     * @param Request $request
     * @return void
     */
    public function updateActivity(Request $request)
    {
        // TODO: Update işlemleri yapılacak
        $update = Activity::where('id', $request->activity_id)
            ->update([
                'yon'       => ($request->activity_direction == 'inbound') ? 0 : 1,
                'hissiyat'  => $request->activity_sense,
                'tip'       => $request->activity_subject,
                'kanal_id'  => $request->activity_channel,
                'not'       => $request->activity_note,
            ]);

        return $update;
    }

    /**
     * Kullanıcıya yönlendirilmiş aktiviteler
     *
     * @param Request $request
     * @return void
     */
    public function assignedActivities(Request $request)
    {
        $title = "Yanıt Bekleyen Aktiviteler";
        $activities = DB::select('SELECT
            activities.id AS activity_id,
            activities.`not` AS activity_note,
            activities.hissiyat AS activity_sense,
            activities.musteri AS consumer_id,
            users.`name` AS created_user,
            activity_cases.`name` AS activity_case,
            activity_subjects.`name` AS activity_subject,
            assignments.note AS assignment_note,
            activities.created_at AS activity_created_at
            FROM (SELECT activity_assignments.* from
            activity_assignments,
                (SELECT max(id) as id
                    FROM activity_assignments
                    GROUP BY aktivite_id) acs
                WHERE activity_assignments.id=acs.id 
                ORDER BY activity_assignments.aktivite_id) AS assignments
            LEFT JOIN activities ON activities.id = assignments.aktivite_id
            LEFT JOIN users ON users.id = assignments.to_user_id
            LEFT JOIN activity_cases ON activity_cases.id = activities.case_id
            LEFT JOIN activity_subjects ON activity_subjects.id = activities.tip
            WHERE assignments.to_user_id = ' . Auth::user()->id);

        return view('cm.assigned-activities', compact('activities', 'title'));
    }

    /**
     * Kullanıcının kendi açtığı aktiviteler
     *
     * @param Request $request
     * @return void
     */
    public function userActivities(Request $request)
    {
        $title = "Aktivitelerim";
        $activities = Activity::select(
            'activities.id AS activity_id',
            'activities.musteri AS consumer_id',
            'ac.name AS activity_case',
            'as.name AS activity_subject',
            'activities.hissiyat AS activity_sense',
            'activities.created_at AS activity_created_at')
            ->leftJoin('activity_cases AS ac', 'ac.id', '=', 'activities.case_id')
            ->leftJoin('activity_subjects AS as', 'as.id', '=', 'activities.tip')
            ->where('activities.sorumlu', Auth::user()->id)
            ->orderBy('activities.id', 'DESC')
            ->paginate(10);

        return view('cm.user-activities', compact('title', 'activities'));
    }

    /**
     * Tüm Aktiviteler
     *
     * @param Request $request
     * @return void
     */
    public function allActivities(Request $request)
    {
        $title = "Tüm Aktiviteler";
        $activities = Activity::select(
            'activities.id AS activity_id',
            'activities.musteri AS consumer_id',
            'ac.name AS activity_case',
            'as.name AS activity_subject',
            'activities.hissiyat AS activity_sense',
            'u.name AS created_user',
            'activities.created_at AS activity_created_at')
            ->leftJoin('activity_cases AS ac', 'ac.id', '=', 'activities.case_id')
            ->leftJoin('activity_subjects AS as', 'as.id', '=', 'activities.tip')
            ->leftJoin('users AS u', 'u.id', '=', 'activities.sorumlu')
            ->orderBy('activities.id', 'DESC')
            ->paginate(10);

        return view('cm.all-activities', compact('title', 'activities'));
    }
}
