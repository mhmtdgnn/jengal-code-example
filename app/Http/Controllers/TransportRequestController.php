<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\City;
use App\Models\TransportRequest;
use App\Models\TransportRequestTypes;
use App\Models\TransportType;
use App\Models\TransportRequestLog;
use App\Models\PickupRequest;
use App\Models\PickupRequestType;
use App\Models\PickupRequestDetail;
use App\Models\PickupRequestStatus;
use App\Models\Employee;
use App\Models\Store;
use App\Models\Product;
use App\Models\PickupRequestLog;
use App\Models\TransportScheduledDelivery;
use App\Models\Vehicle;
use App\Models\ECommerceOrder;
use App\Models\VorwerkOrder;
use App\Models\VorwerkOrderStatus;
use App\Models\VorwerkOrderCargoCode;
use App\Models\VorwerkOrderLog;
use App\Models\UPSDistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DateInterval;
use DatePeriod;
use DateTime;
use stdClass;
use ArrayObject;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PickupRequestExport;
use App\Exports\VorwerkOrdersExport;
use App\Exports\VorwerkOrderEndOfDayReportExport;
use App\Exports\VorwerkProgressPaymentExport;
use App\Imports\ECommerceOrderImport;
use App\Imports\ThermomixOrderImport;
use App\Jobs\SendVerimorSms;
use Carbon\Carbon;
use App\Jobs\ECommerceOrderManagement;
use App\Jobs\UPSCargoManagement;
use App\Models\Town;
use App\Models\TransportRequestFile;
use App\Models\TransportRequestPackage;
use App\Models\TransportRequestStatuses;
use App\Models\VorwerkOrderDetail;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\AssignOp\Concat;
use Symfony\Component\Mailer\Transport;
use SimpleXMLElement;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class TransportRequestController extends Controller
{

    /**
     * Tarih Listesi - Evden alım talepleri için tarih listesi
     *
     * @return void
     */
    private function datePeriod()
    {
        $period = new DatePeriod(
            new DateTime(date('Y-m-d')),
            new DateInterval('P1D'),
            new DateTime(date("Y-m-d", strtotime("+ 16 day")))
        );

        $dateList = new stdClass();
        foreach ($period as $item) {
            if ($item->format('w') != 0) {
                switch ($item->format('w')) {
                    case '1':
                        $day = 'Pazartesi';
                        break;
                    case '2':
                        $day = 'Salı';
                        break;
                    case '3':
                        $day = 'Çarşamba';
                        break;
                    case '4':
                        $day = 'Perşembe';
                        break;
                    case '5':
                        $day = 'Cuma';
                        break;
                    case '6':
                        $day = 'Cumartesi';
                        break;
                }
                $key = $item->getTimestamp();

                $dateList->$key = $item->format('Y-m-d') .  ' ' . $day;
            }
        }

        return $dateList;
    }

    public function showAll()
    {
        $title = "Taşıma Talepleri";

        $transport_requests = TransportRequest::select(
            'transport_requests.id',
            'transport_requests.type_id',
            'transport_requests.status_id',
            'transport_requests.delivery_type',
            'transport_requests.transport_code AS transport_code',
            'transport_requests.appointment_date AS appointment_date',
            'tc.name AS to_city',
            'tt.name AS to_town',
            'transport_requests.to_name AS contact_name',
            'transport_requests.to_phone AS contact_number',
            'transport_requests.created_at AS created_at')
            ->leftJoin('cities AS fc', 'fc.id', '=', 'transport_requests.from_city_id')
            ->leftJoin('towns AS ft', 'ft.id', '=', 'transport_requests.from_town_id')
            ->leftJoin('cities AS tc', 'tc.id', '=', 'transport_requests.to_city_id')
            ->leftJoin('towns AS tt', 'tt.id', '=', 'transport_requests.to_town_id')
            ->whereIn('transport_requests.status_id', [2000, 2030])
            ->orderBy('transport_requests.status_id', 'DESC')
            ->orderBy('transport_requests.id', 'ASC')
            ->paginate(50);

        $transport_request_types = TransportRequestTypes::get();
        $transport_types = TransportType::get();
        $employees = Employee::where('active', 1)->where('job_title_id', 1)->get();
        $cities = City::get();

        $datePeriod = json_encode($this->datePeriod());
        $vehicles = Vehicle::get();

        return view('transport.list', compact('transport_requests', 'datePeriod', 'vehicles', 'transport_request_types', 'transport_types', 'employees', 'cities', 'title'));
    }

    /**
     * Talep Oluştur
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request, $returnType = 'json')
    {
        DB::beginTransaction();
        try {
                $transport = new TransportRequest();
                $transport->transport_code = 1000000000 + random_int(1000000, 9999999);
                $transport->title = $request->title;
                $transport->operation_note = $request->operation_note;
                $transport->type_id = $request->transport_type;
                $transport->delivery_type = $request->delivery_type;
                $transport->desi = isEmpty($request->desi) ? 0 : $request->desi;
                $transport->package_number = $request->package_number;
                $transport->payment_at_door = 0; //$request->payment_at_door;
                $transport->reference_number = $request->reference_number;
                $transport->to_name = $request->contact_name;
                $transport->to_phone = $request->contact_number;
                $transport->to_email = $request->contact_email;
                $transport->to_city_id = $request->destination_city;
                $transport->to_town_id = $request->destination_town;
                $transport->to_address = $request->destination_address;
                $transport->to_location = '';
                $transport->appointment_date = $request->appointment_date;
                $transport->status_id = 2000;
                $transport->save();

                if (isset($request->products)) {
                    foreach ($request->products as $item) {
                        $package = new TransportRequestPackage();
                        $package->transport_request_id = $transport->id;
                        $package->product_id = $item['product_id'];
                        $package->piece = $item['piece'];
                        $package->save();
                    }
                }

                //Taşıma talebi bir sipariş tablosundan geliyorsa
                //Sipariş tipine göre ilgili tablodaki statü ilerletilir...
                switch($transport->type_id){
                    case 2: //Arızalı Ürün Hizmeti İse
                        PickupRequest::where('id', $request->reference_id)->update(['status' => 1010]);
                        PickupRequestLog::create([
                            'pickup_request_id' => $request->reference_id,
                            'user_id'           => Auth::user()->id,
                            'type_key'          => 'approve',
                            'text'              => 'Talep Onaylandı / Taşıma Talebi Oluşturuldu'
                        ]);
                        break;
                    case 3: //VIP Taşıma Hizmeti İse
                        VorwerkOrder::where('id', $request->reference_id)->update(['durum' => 60]);
                        VorwerkOrderLog::create([
                            'user_id' => Auth::user()->id,
                            'order_id' => $request->reference_id,
                            'type_key' => 'delivery_start',
                            'description' => 'Kargoya Teslim Edildi (BiÇözüm)',
                        ]);
                        break;
                }

                $log = new TransportRequestLog();
                $log->user_id       = Auth::user()->id;
                $log->activity_id   = $transport->id;
                $log->type_key      = 'create';
                $log->description   = 'Taşıma kaydı başarıyla kaydedildi.';
                $log->save();

                DB::commit();

                return response()->json(['success' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Ajax
     *
     * @param Request $request
     * @return void
     */
    public function getRequestByID(Request $request)
    {
        $data = TransportRequest::select(
            'transport_requests.id',
            'transport_requests.transport_code',
            'transport_requests.type_id as type_id',
            'transport_requests.delivery_type',
            'transport_requests.operation_note',
            'trt.name as type',
            'transport_requests.reference_number',
            'transport_requests.payment_at_door',
            'transport_requests.to_city_id',
            'tc.name AS to_city',
            'transport_requests.to_town_id',
            'tt.name AS to_town',
            'transport_requests.to_name AS contact_name',
            'transport_requests.to_phone AS contact_number',
            'transport_requests.to_address',)
            ->leftJoin('cities as fc', 'fc.id', '=', 'transport_requests.from_city_id')
            ->leftJoin('towns as ft', 'ft.id', '=', 'transport_requests.from_town_id')
            ->leftJoin('cities as tc', 'tc.id', '=', 'transport_requests.to_city_id')
            ->leftJoin('towns as tt', 'tt.id', '=', 'transport_requests.to_town_id')
            ->leftJoin('transport_request_types as trt', 'trt.id', '=', 'transport_requests.type_id')
            ->find($request->transport_id);

            $data['logs'] = TransportRequestLog::select('transport_request_logs.*', 'u.name AS user_name')
                ->leftJoin('users AS u', 'u.id', '=', 'transport_request_logs.user_id')
                ->where('transport_request_logs.activity_id', $request->transport_id)
                ->get();

        return response()->json($data);
    }

    /**
     * AJAX - Başlangıç adresi güncelle
     *
     * @param Request $request
     * @return void
     */
    public function updateStartAddress(Request $request)
    {
        try {
            $update = TransportRequest::where('id', $request->transport_id)
                ->update([
                    'from_city_id' => $request->city,
                    'from_town_id' => $request->town,
                    'from_address' => $request->address
                ]);
            if ($update) {
                $data = TransportRequest::select('c.name AS city', 't.name AS town')
                    ->leftJoin('cities AS c', 'c.id', '=', 'transport_requests.from_city_id')
                    ->leftJoin('towns AS t', 't.id', '=', 'transport_requests.from_town_id')
                    ->find($request->transport_id);
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Bir hata oluştu']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * AJAX - Teslimat adresi güncelle
     *
     * @param Request $request
     * @return void
     */
    public function updateDeliveryAddress(Request $request)
    {
        try {
            $update = TransportRequest::where('id', $request->transport_id)
                ->update([
                    'to_city_id' => $request->city,
                    'to_town_id' => $request->town,
                    'to_address' => $request->address
                ]);
            if ($update) {
                $data = TransportRequest::select('c.name AS city', 't.name AS town')
                    ->leftJoin('cities AS c', 'c.id', '=', 'transport_requests.to_city_id')
                    ->leftJoin('towns AS t', 't.id', '=', 'transport_requests.to_town_id')
                    ->find($request->transport_id);
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Bir hata oluştu']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * AJAX - Planlama tarihi güncelle
     *
     * @param Request $request
     * @return void
     */
    public function updateAppointmentDate(Request $request)
    {
        try {
            $appointmentDate = date('Y-m-d', $request->appointment_date);
            $update = TransportRequest::where('id', $request->transport_id)
                ->update([
                    'appointment_date' => $appointmentDate,
                ]);
            if ($update) {
                return response()->json(['message' => $appointmentDate]);
            } else {
                return response()->json(['error' => 'Bir hata oluştu']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Sefer Planla
     *
     * @param Request $request
     * @return void
     */
    public function scheduleTransport(Request $request)
    {;
        try {
            DB::transaction(function () use (&$request) {
                TransportScheduledDelivery::updateOrCreate(
                    ['transport_request_id' => $request->transport_id],
                    [
                    'transport_request_id' => $request->transport_id,
                    'planned_date'  => date('Y-m-d', $request->planned_date),
                    'vehicle_id' => $request->vehicle,
                ]);

                $referenceNumber = intval(substr($request->transport_reference_number, 3)) - 10000000;
                switch ($request->transport_type_id) {
                    case 2:
                        PickupRequest::find($referenceNumber)->update(['status' => 1020]);
                        break;
                }

                TransportRequest::find($request->transport_id)->update(['status_id' => 2010, 'operation_note' => $request->operation_note]);

                TransportRequestLog::create([
                    'user_id' => Auth::user()->id,
                    'activity_id' => $request->transport_id,
                    'type_key'      => 'schedule',
                    'description'   => 'Teslimat planlandı.',
                ]);
            });

            return response()->json(['message' => 'Kayıt başarılı']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Planlanmış Taşıma Talepleri Listesi
     *
     * @return void
     */
    public function scheduledTransportation(Request $request)
    {
        $title = 'Planlanmış Talepler';

        $plannedDeliveries = TransportScheduledDelivery::select(
            'tr.transport_code',
            'tr.to_name',
            'type.name AS transport_type',
            's.status_name AS status',
            's.status_color AS status_color',
            'transport_scheduled_deliveries.vehicle_id AS vehicle_id',
            'v.name AS vehicle',
            'v.plate_number',
            'e.name AS driver_name',
            'e.surname AS driver_surname',
            'fc.name AS from_city',
            'ft.name AS from_town',
            'tc.name AS to_city',
            'tt.name AS to_town',
            'tr.to_phone AS contact_number',
            'transport_scheduled_deliveries.planned_date AS planned_date')
            ->leftJoin('transport_requests AS tr', 'tr.id', '=', 'transport_scheduled_deliveries.transport_request_id')
            ->leftJoin('transport_request_types AS type', 'type.id', '=', 'tr.type_id')
            ->leftJoin('vehicles AS v', 'v.id', '=', 'transport_scheduled_deliveries.vehicle_id')
            ->leftJoin('transport_request_statuses AS s', 's.status_code', '=', 'tr.status_id')
            ->leftJoin('employees AS e', 'e.id', '=', 'v.employee_id')
            ->leftJoin('cities AS fc', 'fc.id', '=', 'tr.from_city_id')
            ->leftJoin('towns AS ft', 'ft.id', '=', 'tr.from_town_id')
            ->leftJoin('cities AS tc', 'tc.id', '=', 'tr.to_city_id')
            ->leftJoin('towns AS tt', 'tt.id', '=', 'tr.to_town_id')
            ->whereNotIn('tr.status_id', [2040, 9999]);

        if ($request->fcode) {
            $plannedDeliveries->where('tr.transport_code', '=', $request->fcode);
        }

        if ($request->fname) {
            $plannedDeliveries->where('tr.to_name', 'LIKE', '%' . $request->fname . '%');
        }

        if ($request->fplandate) {
            $plannedDeliveries->where('transport_scheduled_deliveries.planned_date', '=', $request->fplandate);
        }

        if ($request->fstatus) {
            $plannedDeliveries->where('tr.status_id', '=', $request->fstatus);
        }

        $plannedDeliveries = $plannedDeliveries->orderBy('transport_scheduled_deliveries.planned_date', 'ASC')->get();

        $statuses = TransportRequestStatuses::get();

        return view('transport.scheduled_list', compact('title', 'plannedDeliveries', 'statuses'));
    }

    /**
     * Taşıma Talebini İptal Et
     *
     * @param Request $request
     * @return void
     */
    public function transportCancel(Request $request)
    {
        try {
            DB::transaction(function () use (&$request) {
                TransportRequest::find($request->transport_id)->update(['status_id' => 9999]);

                TransportRequestLog::create([
                    'user_id' => Auth::user()->id,
                    'activity_id' => $request->transport_id,
                    'type_key'      => 'cancel',
                    'description'   => 'Talep İptal Edildi',
                ]);
            });

            return response()->json(['message' => 'Kayıt başarılı']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Function that groups an array of associative arrays by some key.
     *
     * @param {String} $key Property to sort by.
     * @param {Array} $data Array that stores multiple associative arrays.
     */
    private function group_by($key, $data) {
        $result = array();

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }

    /**
     * Planlanmış Taşıma Talepleri Listesi
     *
     * @return void
     */
    public function scheduledTransportationVehicle(Request $request, $vehicle_id)
    {
        $title = 'Planlanmış Talepler';

        $data = TransportScheduledDelivery::select(
            'tr.id AS id',
            'tr.delivery_type AS delivery_type',
            'transport_scheduled_deliveries.planned_date AS planned_date',
            'tr.transport_code',
            'tr.to_name',
            'tr.to_phone',
            'tr.to_address',
            'trtype.name AS type',
            's.status_name AS status',
            's.status_color AS status_color',
            'v.name AS vehicle',
            'v.plate_number',
            'e.name AS driver_name',
            'e.surname AS driver_surname',
            'fc.name AS from_city',
            'ft.name AS from_town',
            'tc.name AS to_city',
            'tt.name AS to_town',
            'tr.to_phone AS contact_number',
            'tr.created_at AS created_at')
            ->leftJoin('transport_requests AS tr', 'tr.id', '=', 'transport_scheduled_deliveries.transport_request_id')
            ->leftJoin('transport_request_types AS trtype', 'trtype.id', '=', 'tr.type_id')
            ->leftJoin('vehicles AS v', 'v.id', '=', 'transport_scheduled_deliveries.vehicle_id')
            ->leftJoin('transport_request_statuses AS s', 's.status_code', '=', 'tr.status_id')
            ->leftJoin('employees AS e', 'e.id', '=', 'v.employee_id')
            ->leftJoin('cities AS fc', 'fc.id', '=', 'tr.from_city_id')
            ->leftJoin('towns AS ft', 'ft.id', '=', 'tr.from_town_id')
            ->leftJoin('cities AS tc', 'tc.id', '=', 'tr.to_city_id')
            ->leftJoin('towns AS tt', 'tt.id', '=', 'tr.to_town_id')
            ->where('transport_scheduled_deliveries.vehicle_id', $vehicle_id)
            ->whereNotIn('tr.status_id', [2030, 2040, 9999])
            ->orderBy('transport_scheduled_deliveries.planned_date', 'ASC')
            ->get();

        $vehicle = Vehicle::find($vehicle_id);
        $driver = Employee::find($vehicle->employee_id);

        $deliveryCounts = count($data);
        $x = json_decode(json_encode($data), true);
        $plannedDeliveries = $this->group_by("planned_date", $x);
        // return $plannedDeliveries;

        return view('transport.scheduled_list_courier', compact('title', 'plannedDeliveries', 'vehicle', 'driver', 'deliveryCounts'));

        // if ($request->view == 'courier')
        //     return view('transport.scheduled_list_courier', compact('title', 'plannedDeliveries', 'vehicle', 'driver'));
        // else
        //     return view('transport.scheduled_list_vehicle', compact('title', 'plannedDeliveries', 'vehicle', 'driver'));

    }

    private function transportDetailFunction($view, $transport_code)
    {
        $title = 'Taşıma Detayı';
        $data = TransportScheduledDelivery::select(
            'transport_scheduled_deliveries.id AS delivery_id',
            'tr.id AS transport_id',
            'tr.type_id AS type_id',
            'tr.operation_note',
            'tr.delivery_type AS delivery_type',
            'transport_scheduled_deliveries.planned_date AS planned_date',
            'tr.transport_code',
            'trt.name AS type_name',
            'tr.reference_number',
            's.status_code AS status_code',
            's.status_name AS status',
            's.status_color AS status_color',
            'v.name AS vehicle',
            'v.plate_number',
            'e.name AS driver_name',
            'e.surname AS driver_surname',
            'fc.name AS from_city',
            'ft.name AS from_town',
            'tr.from_name AS from_name',
            'tr.from_phone AS from_phone',
            'tc.name AS to_city',
            'tt.name AS to_town',
            'tr.to_name AS to_name',
            'tr.to_phone AS to_phone',
            'tr.to_email AS to_email',
            'tr.from_address',
            'tr.to_address',
            'tr.created_at AS created_at')
            ->leftJoin('transport_requests AS tr', 'tr.id', '=', 'transport_scheduled_deliveries.transport_request_id')
            ->leftJoin('vehicles AS v', 'v.id', '=', 'transport_scheduled_deliveries.vehicle_id')
            ->leftJoin('transport_request_statuses AS s', 's.status_code', '=', 'tr.status_id')
            ->leftJoin('employees AS e', 'e.id', '=', 'v.employee_id')
            ->leftJoin('cities AS fc', 'fc.id', '=', 'tr.from_city_id')
            ->leftJoin('towns AS ft', 'ft.id', '=', 'tr.from_town_id')
            ->leftJoin('cities AS tc', 'tc.id', '=', 'tr.to_city_id')
            ->leftJoin('towns AS tt', 'tt.id', '=', 'tr.to_town_id')
            ->leftJoin('transport_request_types AS trt', 'trt.id', '=', 'tr.type_id')
            ->where('tr.transport_code', $transport_code)
            ->first();

        $packages = TransportRequestPackage::where('transport_request_id', $data->transport_id)
            ->with('product')
            ->get();

        $logs = TransportRequestLog::where('activity_id', $data->transport_id)->with('user')->get();
        $files = TransportRequestFile::where('transport_request_id', $data->transport_id)->get();

        $serviceID = (int) substr($data->reference_number, 6);
        $service = PickupRequest::with([
            'consumer',
            'consumerAddress',
            'statusInfo',
            'details' => function ($q) {
                $q->select('pickup_request_details.*', 'p.product_code', 'p.product_name');
                $q->leftJoin('products as p', 'p.id', '=', 'pickup_request_details.product_id');
                $q->orderby('p.product_code', 'asc');
            }
        ])->find($serviceID);

        $vipOrderID = (int) substr($data->reference_number, 6);
        $vipDeliveryProducts = VorwerkOrderDetail::with('prod')->where('order_id',$vipOrderID)->get();

        switch ($view) {
            case 'courier':
                return view('transport.scheduled_detail', compact('title', 'data', 'service', 'packages', 'vipDeliveryProducts'));
                break;
            case 'view':
                return view('transport.scheduled_detail_view', compact('title', 'data', 'service', 'packages', 'vipDeliveryProducts', 'logs', 'files'));
                break;
        }
    }

    /**
     * Kurye Ekranı
     * Taşıma Talebi Detayları
     *
     * @param [type] $transport_id
     * @return void
     */
    public function transportDetail($transport_code)
    {
        return $this->transportDetailFunction('courier', $transport_code);
    }

    /**
     * Kurye Ekranı
     * Taşıma Talebi Detayları
     *
     * @param [type] $transport_id
     * @return void
     */
    public function transportDetailView($transport_code)
    {
        return $this->transportDetailFunction('view', $transport_code);
    }

    /**
     * Kurye Göreve Başlama İşlemi
     *
     * @param Request $request
     * @return void
     */
    public function courierStartDelivery(Request $request)
    {
        try {
            DB::transaction(function () use (&$request) {
                TransportScheduledDelivery::find($request->delivery_id)
                    ->update(['departure_time' => Carbon::now()]);

                TransportRequest::find($request->transport_request_id)
                    ->update(['status_id' => 2020]);

                TransportRequestLog::create([
                    'user_id'       => Auth::user()->id,
                    'activity_id'   => $request->transport_request_id,
                    'type_key'      => 'delivery_start',
                    'description'   => 'Kurye dağıtıma başladı.'
                ]);
            });

            return response()->json(['success']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Tüm Taşıma Talepleri
     * Liste - Arama - Filtreleme
     *
     * @return void
     */
    public function allTransportation(Request $request)
    {
        $title = "Tüm Talepler";
        $transports = TransportRequest::leftJoin('transport_scheduled_deliveries AS tsd', 'tsd.transport_request_id', '=', 'transport_requests.id');

        if ($request->fcode) {
            $transports->where('transport_requests.transport_code' ,$request->fcode);
        }

        if ($request->fstatus) {
            $transports->where('transport_requests.status_id', $request->fstatus);
        }

        if ($request->fname) {
            $transports->where('transport_requests.to_name', 'LIKE', '%'.$request->fname.'%');
        }

        if ($request->fplandate) {
            $transports->where('tsd.planned_date', '=', $request->fplandate);
        }

        $transports = $transports->orderBy('transport_requests.created_at', 'DESC')->paginate(15);
        $transports = $transports->appends($request->except('page'));

        $statuses = TransportRequestStatuses::get();

        return view('transport.all_transport_list', compact('title','transports', 'statuses'));
    }

    public function transportRequestFiles()
    {
        $files = TransportRequestFile::where('created_at', '>', '2023-03-21')->where('created_at', '<', '2023-04-07')->get();

        return view('transport.files', compact('files'));
    }

    public function pickupRequests(Request $request)
    {
        $title = 'Evden Alım Talepleri';

        $types = PickupRequestType::where('active', 1)->get();
        $statuses = PickupRequestStatus::get();
        $pickups = PickupRequest::select('pickup_requests.*', 'prs.status_name', 'prs.status_color', 'company.logo_url')
            ->with('service')
            ->leftJoin('pickup_request_statuses AS prs', 'prs.status_code', '=', 'pickup_requests.status')
            ->leftJoin('users AS user', 'user.id', '=', 'pickup_requests.user_id')
            ->leftJoin('companies AS company', 'company.id', '=', 'user.company_id');

        if ($request->filter_request_code) {
            $pickups->requestCode($request->filter_request_code);
        }

        if ($request->filter_request_type) {
            $pickups->requestType($request->filter_request_type);
        }

        if ($request->filter_status) {
            $pickups->status($request->filter_status);
        }

        if ($request->filter_consumer_firstname) {
            $consumers = Consumer::consumerFirstName($request->filter_consumer_firstname)->pluck('id');
            $pickups->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_lastname) {
            $consumers = Consumer::consumerLastName($request->filter_consumer_lastname)->pluck('id');
            $pickups->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_phone) {
            $consumers = Consumer::consumerPhone($request->filter_consumer_phone)->pluck('id');
            $pickups->whereIn('consumer_id', $consumers);
        }

        $pickups = $pickups->orderBy('pickup_requests.created_at', 'DESC')->paginate(30);
        $pickups = $pickups->appends($request->except('page'));

        return view('transport.pickup_requests', compact('pickups', 'types', 'statuses', 'title'));
    }

    public function companyPickupRequests(Request $request)
    {
        $title = 'Evden Alım Talepleri';

        $types = PickupRequestType::where('active', 1)->get();
        $statuses = PickupRequestStatus::get();
        $pickups = PickupRequest::select(
            'pickup_requests.id',
            'pickup_requests.created_at',
            'prt.name',
            'consumers.firstName',
            'prs.status_name',
            'prs.status_color',
            'consumers.lastName',
            'consumers.phone'
        )
            ->leftJoin('users', 'users.id', '=', 'pickup_requests.user_id')
            ->leftJoin('pickup_request_types as prt', 'prt.id', '=', 'pickup_requests.type')
            ->leftJoin('consumers', 'consumers.id', '=', 'pickup_requests.consumer_id')
            ->leftJoin('pickup_request_statuses AS prs', 'prs.status_code', '=', 'pickup_requests.status');

        if ($request->filter_request_code) {
            $pickups->requestCode($request->filter_request_code);
        }

        if ($request->filter_request_type) {
            $pickups->requestType($request->filter_request_type);
        }

        if ($request->filter_status) {
            $pickups->status($request->filter_status);
        }

        if ($request->filter_consumer_firstname) {
            $consumers = Consumer::consumerFirstName($request->filter_consumer_firstname)->pluck('id');
            $pickups->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_lastname) {
            $consumers = Consumer::consumerLastName($request->filter_consumer_lastname)->pluck('id');
            $pickups->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_phone) {
            $consumers = Consumer::consumerPhone($request->filter_consumer_phone)->pluck('id');
            $pickups->whereIn('consumer_id', $consumers);
        }

        $pickups = $pickups->where('users.company_id', Auth::user()->company_id)->orderBy('pickup_requests.created_at', 'DESC')->paginate(30);
        $pickups = $pickups->appends($request->except('page'));

        return view('transport.company_pickup_requests', compact('pickups', 'types', 'statuses', 'title'));
    }

    public function myPickupRequests(Request $request)
    {
        $title = 'Evden Alım Taleplerim';

        $types = PickupRequestType::where('active', 1)->get();
        $statuses = PickupRequestStatus::get();
        $pickups = PickupRequest::select()
            ->leftJoin('pickup_request_statuses AS prs', 'prs.status_code', '=', 'pickup_requests.status');

        if ($request->filter_request_code) {
            $pickups->requestCode($request->filter_request_code);
        }

        if ($request->filter_request_type) {
            $pickups->requestType($request->filter_request_type);
        }

        if ($request->filter_status) {
            $pickups->status($request->filter_status);
        }

        if ($request->filter_consumer_firstname) {
            $consumers = Consumer::consumerFirstName($request->filter_consumer_firstname)->pluck('id');
            $pickups->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_lastname) {
            $consumers = Consumer::consumerLastName($request->filter_consumer_lastname)->pluck('id');
            $pickups->whereIn('consumer_id', $consumers);
        }

        if ($request->filter_consumer_phone) {
            $consumers = Consumer::consumerPhone($request->filter_consumer_phone)->pluck('id');
            $pickups->whereIn('consumer_id', $consumers);
        }

        $pickups = $pickups->where('user_id', Auth::user()->id)->orderBy('pickup_requests.created_at', 'DESC')->paginate(30);
        $pickups = $pickups->appends($request->except('page'));

        return view('transport.my_pickup_requests', compact('pickups', 'types', 'statuses', 'title'));
    }

    public function createPickupRequest()
    {
        $title = 'Evden Alım Hizmet Talebi';

        if (!empty(Auth::user()->affiliated_company)) {
            $affiliatedCompanies = json_decode(Auth::user()->affiliated_company);
        } else {
            $affiliatedCompanies = [];
        }

        array_push($affiliatedCompanies,  Auth::user()->company_id);

        $products = Product::select('id', 'product_code', 'product_name')->whereIn('company_id', $affiliatedCompanies)->get();
        $stores = Store::where('status', 1)->get();
        $types = PickupRequestType::where('active', 1)->get();
        $cities = City::get();
        return view('transport.create_home_service', compact('title', 'products', 'stores', 'types', 'cities'));
    }

    public function storePickupRequest(Request $request)
    {
        $rows = $request->product;
        $pickUpRequest = new PickupRequest();
        $pickUpRequest->user_id         = Auth::user()->id;
        $pickUpRequest->store_id        = 0; //Auth::user()->store->id;
        $pickUpRequest->consumer_id     = $request->consumerID;
        $pickUpRequest->address_id      = $request->consumer_address;
        $pickUpRequest->type            = $request->request_type;
        $pickUpRequest->status          = 1000;
        $pickUpRequest->piece           = count($rows);
        $pickUpRequest->note            = $request->notes;
        $pickUpRequest->invoice_amount  = count($rows) * 0; //!satır sayısına göre fiyat hesaplaması
        $pickUpRequest->whopays         = $request->odeyen;
        $pickUpRequest->paying_type     = ($request->odeyen == 'firma_oder') ? '' : $request->payment_type;
        $pickUpRequest->spare_product   = (isset($request->spare_product)) ? $request->spare_product : 0;
        $pickUpRequest->save();

        foreach ($rows as $row) {
            $detail = new PickupRequestDetail();
            $detail->pickup_request_id = $pickUpRequest->id;
            $detail->product_id        = $row['product_id'];
            $detail->description       = $row['complaint'];
            $detail->has_warranty      = $row['warranty'];
            $detail->save();
        }

        PickupRequestLog::create([
            'pickup_request_id' => $pickUpRequest->id,
            'user_id'           => Auth::user()->id,
            'type_key'          => 'start',
            'text'              => 'Talep oluşturuldu'
        ]);

        return $pickUpRequest;
    }

    public function exportPickupRequest()
    {
        $fileName = date('YmdHis') . '-talep-detay.xlsx';
        (new PickupRequestExport)->download($fileName);

        return back()->with('msg', 'Dışarı aktarma işlemi birazdan başlayacaktır.');
    }

    public function pickupRequestDetail($id)
    {
        $title = "Talep Detayı";
        $pickUpRequest = PickUpRequest::select(
            'pickup_requests.*',
            'ca.address AS address',
            'ca.address_name AS address_name',
            'c.name AS city',
            't.name As town')
            ->leftJoin('consumer_addresses AS ca', 'ca.id', '=', 'pickup_requests.address_id')
            ->leftJoin('cities AS c', 'c.id', '=', 'ca.city')
            ->leftJoin('towns AS t', 't.id', '=', 'ca.town')
            ->find($id);

        $datePeriod = json_encode($this->datePeriod());
        $logs = PickupRequestLog::where('pickup_request_id', $id)->get();

        $relatedTransportRequest = TransportRequest::select(
            'transport_requests.id',
            'transport_requests.transport_code',
            'transport_requests.reference_number',
            'transport_requests.to_name',
            'transport_requests.to_phone',
            'transport_requests.to_address',
            'transport_requests.payment_at_door',
            'transport_requests.delivery_type',  // 0 => Teslim Al || 1 => Teslim Et
            't.name AS town',
            'c.name AS city',
            'tt.name AS transport_type',)
            ->where('reference_number', 'SBC' . 10000000 + $id)
            ->leftJoin('cities AS c', 'c.id', '=', 'transport_requests.to_city_id')
            ->leftJoin('towns AS t', 't.id', '=', 'transport_requests.to_town_id')
            ->leftJoin('transport_request_types AS tt', 'tt.id', '=', 'transport_requests.type_id')
            ->with('logs')
            ->get();

        return view('transport.pickup_request_detail', compact('title', 'pickUpRequest', 'logs', 'datePeriod', 'relatedTransportRequest'));
    }

    /**
     * Talep Kabul işlemi
     * Talep kabul edildiğinde taşıma talebi oluşturulur
     * Randevu tarihi gereklidir.
     *
     * @param Request $request
     * @return void
     */
    public function pickupRequestApprove(Request $request)
    {
        // return date('Y-m-d', $request->date);
        //Talep bilgilerini al
        $pickUpRequest = PickupRequest::select(
            'pickup_requests.*',
            'ca.address AS address',
            'ca.address_name AS address_name',
            'c.id AS city_id',
            't.id As town_id')
            ->leftJoin('consumer_addresses AS ca', 'ca.id', '=', 'pickup_requests.address_id') // Seçilen adress
            ->leftJoin('cities AS c', 'c.id', '=', 'ca.city')
            ->leftJoin('towns AS t', 't.id', '=', 'ca.town')
            ->find($request->pickup_request_id);

        try {
            switch ($pickUpRequest->type) {
                case 1: // Evden Alım İse
                    $deliveryType = 0; // Teslim Al
                    break;
                case 2: // Eve Teslim İse
                    $deliveryType = 1; // Teslim Et
                    break;
                case 6: // Evden Eve İse
                    $deliveryType = ($pickUpRequest->status == 1036) ? 1 : 0; // 0 => Teslim Al || 1 => Teslim Et
                    break;
            }
            // ! BEGIN::Talebe bağlı taşıma talebi oluştur */
            $data["package_number"] = 0;
            $data["payment_at_door"] = 0;
            $data["title"] = "";
            $data["description"] = $pickUpRequest->note ?? "";
            $data["transport_type"] = 2; // Arızalı Ürün Taşıma
            $data["delivery_type"] = $deliveryType; //($pickUpRequest->type == 1) ? 0 : 1; // 0 => Teslim Al || 1 => Teslim Et
            $data["desi"] = 0;
            $data["reference_number"] = 'SBC' . 10000000 + $request->pickup_request_id;
            $data["reference_id"] = $request->pickup_request_id;
            $data["appointment_date"] = date('Y-m-d', $request->date);
            $data["contact_name"] = $pickUpRequest->consumer->firstName . ' ' . $pickUpRequest->consumer->lastName;
            $data["contact_number"] = $pickUpRequest->consumer->phone;
            $data["contact_email"] = $pickUpRequest->consumer->email;
            $data["destination_city"] = $pickUpRequest->city_id;
            $data["destination_town"] = $pickUpRequest->town_id;
            $data["destination_address"] = $pickUpRequest->address;
            $data["destination_location"] = '';

            $transportData = new Request();
            $transportData->replace($data);
            $create = $this->store($transportData, false);
            // ! END::Talebe bağlı taşıma talebi oluştur *

            return $create;
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Talep İptali
     * Talep yalnızca ilk aşamada iptal edileblir. (status 1000 iken)
     *
     * @param Request $request
     * @return void
     */
    public function pickupRequestCancel(Request $request)
    {
        try {
            $update = PickupRequest::where('id', $request->id)->where('status', 1000)->update(['status' => 9999]);

            return $update ? true : false;
        } catch (\Throwable $th) {
            return $th;
            // return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Arızalı Ürün Siparişi Tamir Tamamlandı Olarak İşaretlenir
     *
     * @param Request $request
     * @return void
     */
    public function pickupRequestRepairComplete(Request $request)
    {
        try {
            DB::transaction(function() use($request) {
                $update = PickupRequest::where('id', $request->id)->update(['status' => 1036, 'repair' => 1]);

                PickupRequestLog::create([
                    'pickup_request_id' => $request->id,
                    'user_id'           => Auth::user()->id,
                    'type_key'          => 'repair',
                    'text'              => 'Tamir Tamamlandı'
                ]);

            });
            return true;
        } catch (\Throwable $th) {
            return false;
            // return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function vorwerkOrderList(Request $request)
    {
        $title = "Vorwerk Sipariş Listesi";
        $cities = UPSDistrict::select('city_id', 'city_name')->groupBy('city_id', 'city_name')->get();
        $status = VorwerkOrderStatus::get();

        // Get a Builder instance
        $orders = VorwerkOrder::with('detail', 'consumer', 'statu', 'cargoCodes');

        if ($request->filter_order_code) {
            $orders->orderCode($request->filter_order_code);
        }

        if ($request->filter_statu) {
            $orders->statu($request->filter_statu);
        }

        if ($request->filter_transfer_method) {
            $orders->transferMethod($request->filter_transfer_method);
        }

        if ($request->filter_consumer_firstname) {
            $consumers = Consumer::consumerFirstName($request->filter_consumer_firstname)->pluck('id');
            $orders->whereIn('consumer_id', $consumers);
            $orders->destinationContactFirstName($request->filter_consumer_firstname);
        }

        if ($request->filter_consumer_lastname) {
            $consumers = Consumer::consumerLastName($request->filter_consumer_lastname)->pluck('id');
            $orders->whereIn('consumer_id', $consumers);
            $orders->destinationContactLastName($request->filter_consumer_lastname);
        }

        if ($request->filter_consumer_phone) {
            $consumers = Consumer::consumerPhone($request->filter_consumer_phone)->pluck('id');
            $orders->whereIn('consumer_id', $consumers);
        }

        $orders = $orders->orderBy('created_at', 'DESC')->paginate(30);
        $orders = $orders->appends($request->except('page'));

        return view('transport.vorwerk_order_list', compact('title', 'orders', 'cities', 'status'));
    }

    public function vorwerkOrderImport(Request $request)
    {
        Excel::import(new ThermomixOrderImport(), $request->file('importFile'));
        return back()->with('msg', 'Sipariş Listesi Başarıyla İçe Aktarılmıştır.');
    }

    public function vorwerkOrderExport(Request $request)
    {
        if ($request->start_date) {
            $data['start_date'] = $request->start_date;
        } else {
            $data['start_date'] = null;
        }

        if ($request->end_date) {
            $data['end_date'] = $request->end_date;
        } else {
            $data['end_date'] = null;
        }

        $fileName = date('YmdHis') . '-vorwerk-siparisler.xlsx';
        return Excel::download(new VorwerkOrdersExport($data), $fileName);
    }

    public function vorwerkOrderUpdateGiftMethod(Request $request)
    {
        $order = VorwerkOrder::find($request->order_id);
        if ($order->hediye_urun == 1) {
            VorwerkOrder::where('id', $order->id)->update(['hediye_urun' => 0]);
            $orderLog = new VorwerkOrderLog();
            $orderLog->user_id = Auth::user()->id;
            $orderLog->order_id = $request->order_id;
            $orderLog->type_key = 'gift_update';
            $orderLog->description = 'Sipariş hediye ürün bilgisi HAYIR olarak güncellenmiştir';
            $orderLog->save();

            return 'Hayır';
        } else {
            VorwerkOrder::where('id', $order->id)->update(['hediye_urun' => 1]);
            $orderLog = new VorwerkOrderLog();
            $orderLog->user_id = Auth::user()->id;
            $orderLog->order_id = $request->order_id;
            $orderLog->type_key = 'gift_update';
            $orderLog->description = 'Sipariş hediye ürün bilgisi EVET olarak güncellenmiştir';
            $orderLog->save();

            return 'Evet';
        }
    }

    public function vorwerkOrderAddSerialNumber(Request $request)
    {
        $order = VorwerkOrder::find($request->order_id);
        return view('transport.partials.modals.vorwerk_order_add_serial_number', compact('order'));
    }

    public function vorwerkOrderSaveSerialNumber(Request $request)
    {
        $code = explode(' ', $request->serial_code);
        $order = VorwerkOrder::with(
            [
                'detail' => function ($q) {
                    $q->select('vorwerk_order_details.*', 'p.product_code', 'p.product_name');
                    $q->leftJoin('products as p', 'vorwerk_order_details.product_id', '=', 'p.id');
                }
            ]
        )
            ->findOrFail($request->order_id)
            ->toArray();

        $array = array_column($order['detail'], 'product_code');

        if (in_array('62217', $array) or in_array('62651', $array)) {
            if (empty($order['product_serial_numbers'])) {
                VorwerkOrder::where('id', $request->order_id)->update(['product_serial_numbers' => $code]);
            } else {
                $serial = json_decode($order['product_serial_numbers']);
                array_push($serial,  $request->serial_code);

                VorwerkOrder::where('id', $request->order_id)->update(['product_serial_numbers' => json_encode($serial)]);
            }
        } else {
            return 'error';
        }

    }

    public function vorwerkOrderRemoveSerialNumber(Request $request)
    {
        $order = VorwerkOrder::findOrFail($request->order_id);
        $serialCodes = json_decode($order->product_serial_numbers);
        $serialSearch = array_search($request->serial_code, $serialCodes);

        foreach (array_keys($serialCodes, $request->serial_code) as $key) {
            unset($serialCodes[$key]);
        }

        VorwerkOrder::where('id', $request->order_id)->update(['product_serial_numbers' => json_encode($serialCodes)]);
    }

    public function vorwerkOrderShipUpsCargoCode(Request $request)
    {
        $cargoCode = $request->cargo_code;
        $order = VorwerkOrder::with(
            [
                'detail' => function ($q) {
                    $q->select('vorwerk_order_details.*', 'p.product_code', 'p.product_name');
                    $q->leftJoin('products as p', 'vorwerk_order_details.product_id', '=', 'p.id');
                }
            ]
        )
            ->where('gonderi_takip_no', $cargoCode)
            ->first()
            ->toArray();

        $array = array_column($order['detail'], 'product_code');

        if (in_array('62217', $array) or in_array('62651', $array)) {
            if (empty($order['product_serial_numbers'])) {
                return 'emptySerial';
            }
        }

        if (empty($order['shipped'])) {
            VorwerkOrder::where('id', $order['id'])->update(['durum' => 50, 'shipped' => date('Y-m-d H:i:s')]);

            $orderLog = new VorwerkOrderLog();
            $orderLog->user_id = Auth::user()->id;
            $orderLog->order_id = $order['id'];
            $orderLog->type_key = 'shipped';
            $orderLog->description = 'Siparişe bağlı kargo kodu için barkod okutma işlemi gerçekleştirilmiştir.';
            $orderLog->save();
        } else {
            return 'exist';
        }
    }

    public function getEndOfDayReport(Request $request)
    {
        if ($request->date) {
            $data['date'] = $request->date;
        } else {
            $data['date'] = date('Y-m-d');
        }

        $fileName = date('YmdHis') . '-gun-sonu-raporu.xlsx';
        return Excel::download(new VorwerkOrderEndOfDayReportExport($data), $fileName);
    }

    public function vorwerkOrderProgressPaymentList()
    {
        $title = "Vorwerk Hakediş Listesi";

        $dates = VorwerkOrder::select('faturalanma_tarihi')
            ->whereNotNull('faturalanma_tarihi')
            ->groupBy('faturalanma_tarihi')
            ->get();

        $orders = VorwerkOrder::with('detail', 'consumer', 'statu', 'cargoCodes')
            ->whereNull('faturalanma_tarihi')
            ->whereIn('durum', [60,90])
            ->orderBy('created_at', 'DESC')
            ->paginate(100);

        return view('transport.vorwerk_order_progress_payment_list', compact('title', 'orders', 'dates'));
    }

    public function vorwerkOrderCreateProgressPaymentList(Request $request)
    {
        $ids = explode(',', $request->choosen);
        $hakedis_durumu = VorwerkOrder::whereIn('id', $ids)->update(['faturalanma_tarihi' => date('Y-m')]);
    }

    public function vorwerkOrderProgressPaymentDownload(Request $request)
    {
        return Excel::download(new VorwerkProgressPaymentExport($request->faturalanma_tarihi), 'vorwerk-hakedis-listesi.xlsx');
    }

    public function vorwerkOrderEditTransferMethod(Request $request)
    {
        $order = VorwerkOrder::find($request->order_id);
        return view('transport.partials.modals.vorwerk_order_update_transfer_method', compact('order'));
    }

    public function vorwerkOrderUpdateTransferMethod(Request $request)
    {
        $order = VorwerkOrder::find($request->order_id);
        if ($request->transfer == 'YOK') {
            VorwerkOrder::where('id', $request->order_id)->update(['transfer_yontemi' => $request->transfer, 'durum' => 4]);

            $orderLog = new VorwerkOrderLog();
            $orderLog->user_id = Auth::user()->id;
            $orderLog->order_id = $request->order_id;
            $orderLog->type_key = 'address_update';
            $orderLog->description = 'Sipariş hatalı adres bilgisi ile kaydedilmiştir.';
            $orderLog->save();
        } else {
            VorwerkOrder::where('id', $request->order_id)->update(['transfer_yontemi' => $request->transfer, 'durum' => 5]);

            $orderLog = new VorwerkOrderLog();
            $orderLog->user_id = Auth::user()->id;
            $orderLog->order_id = $request->order_id;
            $orderLog->type_key = 'transfer_method_update';
            $orderLog->description = 'Sipariş transfer yöntemi ' . $request->transfer . ' olarak güncellenmiştir.';
            $orderLog->save();
        }

        return back()->with('msg', 'Sipariş Transfer Yöntemi Başarıyla Güncellenmiştir.! Sipariş Kodu: ' . $order->siparis_kodu);
    }

    public function vorwerkOrderGetSelectedAddress(Request $request)
    {
        $address = VorwerkOrder::find($request->orderID);

        return $address;
    }

    public function upsTowns(Request $request)
    {
        $response = UPSDistrict::select('area_id', 'area_name')->where('city_id', $request->city_id)->get();

        return $response;
    }

    public function vorwerkOrderUpdateAddress(Request $request)
    {
        try {
            $update = VorwerkOrder::where('id', $request->orderID)
                ->update(
                    [
                        'teslimat_adresi1'      => $request->teslimat_adresi1,
                        'teslimat_adresi2'      => $request->teslimat_adresi2,
                        'teslimat_tarif'        => $request->teslimat_tarif,
                        'teslimat_posta_kodu'   => $request->teslimat_posta_kodu,
                        'teslimat_il_ups'       => $request->address_city,
                        'teslimat_ilce_ups'     => $request->address_town,
                    ]
                );
        } catch (\Throwable $th) {
            throw $th;
        }

        return VorwerkOrder::select('ups_districts.city_name', 'ups_districts.area_name')
            ->where('vorwerk_orders.id', $request->orderID)
            ->leftJoin('ups_districts', 'ups_districts.area_id', '=', 'vorwerk_orders.teslimat_ilce_ups')
            ->first();
    }

    public function createUPSCargoCode(Request $request)
    {
        if (isset($request->order_id)) {
            $order = VorwerkOrder::find($request->order_id);
            return view('transport.partials.modals.vorwerk_order_create_ups_cargo_code', compact('order'));
        } else {
            $check = VorwerkOrder::with('cargoCodes')
                ->where('transfer_yontemi', 'UPS')
                ->whereNull('gonderi_takip_no')
                ->whereNot('durum', 3)
                ->where(
                    function ($q) {
                        $q->whereNull('teslimat_il_ups')
                            ->orWhereNull('teslimat_ilce_ups');
                    }
                )
                ->get();

            if (count($check) > 0) {
                return back()->withErrors(['Tespit edilen siparişler için il, ilçe eşleme sorunu yaşanmaktadır. Siparişleri kontrol ediniz!']);
            } else {
                $orders = VorwerkOrder::with(
                    [
                        'detail' => function ($q) {
                            $q->select('vorwerk_order_details.*', 'p.product_code', 'p.product_name');
                            $q->leftJoin('products as p', 'vorwerk_order_details.product_id', '=', 'p.id');
                        },
                        'consumer',
                        'cargoCodes'
                    ]
                )
                    ->where('transfer_yontemi', 'UPS')
                    ->whereNull('gonderi_takip_no')
                    ->whereIn('durum', [1,5])
                    ->get()
                    ->toArray();

                foreach ($orders as $item) {
                    $array = array_column($item['detail'], 'product_code');
                    $count = 0;
                    $tm6Count = 0;
                    $tm6BlackCount = 0;

                    foreach ($array as $key => $value) {
                        if (strstr($value, '62217')) {
                            $tm6Count = $tm6Count+1;
                        }
                    }

                    foreach ($array as $key => $value) {
                        if (strstr($value, '62651')) {
                            $tm6BlackCount = $tm6BlackCount+1;
                        }
                    }
                    $count = $tm6Count + $tm6BlackCount;

                    $data['numberOfPackage'] = ($count == 0) ?  1 : $count;
                    $data['order'] = $item;
                    $data['method'] = 'bulk-create';
                    $data['user_id'] = Auth::user()->id;
                    UPSCargoManagement::dispatch($data)->onQueue('notification');
                }
            }

            return back()->with('msg', 'Tespit edilen siparişler için UPS kargo kodları başarıyla oluşturulmuştur.');
        }
    }

    public function createSingleUPSCargoCode(Request $request)
    {
        $order = VorwerkOrder::find($request->order_id);

        if (empty($order->gonderi_takip_no)) {
            $data['method'] = 'single-create';
            $data['numberOfPackage'] = $request->numberOfPackage;
            $data['order'] = $order;
            $data['user_id'] = Auth::user()->id;
            UPSCargoManagement::dispatch($data)->onQueue('notification');

            return back()->with('msg', 'Sipariş için UPS kargo kodları başarıyla oluşturulmuştur. Sipariş No: ' . $order->siparis_kodu);
        } else {
            return back()->with('msg', 'Sipariş için UPS kargo kodu bulunmaktadır. Sipariş No: ' . $order->siparis_kodu);
        }
    }

    public function synchronizeUPSCargo()
    {
        $orders = VorwerkOrder::with('cargoCodes', 'consumer')
            ->where('transfer_yontemi', 'UPS')
            ->whereNot('durum', 90)
            ->whereNotNull('gonderi_takip_no')
            ->get();

        foreach ($orders as $item) {
            $data['method'] = 'synchronize-transaction';
            $data['order'] = $item;
            $data['user_id'] = Auth::user()->id;
            UPSCargoManagement::dispatch($data)->onQueue('notification');
        }

        return back()->with('msg', 'Sipariş durumları için UPS Kargo entegrasyonu başarıyla gerçeklişmiştir.');
    }

    public function synchronizeUPSFreight()
    {
        $orders = VorwerkOrder::with('cargoCodes', 'consumer')
            ->where('transfer_yontemi', 'UPS')
            ->whereIn('durum', [60,90])
            ->whereNotNull('gonderi_takip_no')
            ->get();

        foreach ($orders as $item) {
            $data['method'] = 'synchronize-freight';
            $data['order'] = $item;
            $data['user_id'] = Auth::user()->id;
            UPSCargoManagement::dispatch($data)->onQueue('notification');
        }

        return back()->with('msg', 'Desi bilgisi için UPS Kargo entegrasyonu başarıyla gerçeklişmiştir.');
    }

    public function removeUpsCargoCode(Request $request)
    {
        $cargoCode = VorwerkOrderCargoCode::find($request->cargo_code);
        VorwerkOrderCargoCode::where('id', $request->cargo_code)->delete();
        VorwerkOrder::where('id', $cargoCode->order_id)->update(['gonderi_takip_no' => null, 'barcode_printed' => 0]);
    }

    public function verimorSendSms($phone, $message)
    {
        //$mailMessage = 'Değerli müşterimiz, xxx nolu sipairişiniz kargoya verilmiştir. Siparişinizin kargo takibini aşağıdaki linkten gerçekleştirebilirsiniz. Sağlıklı ve lezzetli günler dileriz. Vorwerk Türkiye, https://portal.bicozum.com/order-tracking/'.$siparisNo;
        $messages = ['msg' => $message, 'dest' => "90" . $phone];

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://sms.verimor.com.tr/v2/send.json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                "username"    : "908502553000",
                "password"    : "24122412N.",
                "datacoding"  : "1",
                "messages": ' . json_encode($messages) . '
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                CURLOPT_SSLVERSION => 6,
                CURLOPT_SSL_VERIFYPEER => 0
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function vorwerkOrderPreview(Request $request)
    {
        $order = VorwerkOrder::with(
            [
                'detail' => function ($q) {
                    $q->select('vorwerk_order_details.*', 'p.product_code', 'p.product_name');
                    $q->leftJoin('products as p', 'vorwerk_order_details.product_id', '=', 'p.id');
                    $q->orderby('p.product_code', 'asc');
                },
                'consumer',
                'statu',
                'ups_il',
                'ups_ilce'
            ]
        )->find($request->id);

        $log = VorwerkOrderLog::with('kullanici')
            ->where('order_id', $request->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('transport.partials.modals.vorwerk-detail-modal', compact('order', 'log'));
    }

    public function vorwerkOrderReject(Request $request)
    {
        try {
            VorwerkOrder::where('id', $request->id)->update(['durum' => 3]);

            $orderLog = new VorwerkOrderLog();
            $orderLog->user_id = Auth::user()->id;
            $orderLog->order_id = $request->id;
            $orderLog->type_key = 'order_reject';
            $orderLog->description = 'Sipariş iptal edilmiştir';
            $orderLog->save();
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }

    public function orderTrack($order)
    {
        $order = VorwerkOrder::with('consumer', 'statu', 'cargoCodes')->where('siparis_kodu', $order)->first();
        return view('transport.vorwerk_order_track', compact('order'));
    }

    public function printCargoBarcode(Request $request)
    {
        if (isset($request->cargo_code)) {
            $orderCargo = VorwerkOrderCargoCode::find($request->cargo_code);
            $image = '<img id="printable_barcode" src="' . env('APP_CDN') . $orderCargo->gonderi_barkod_link . '"/>';

            return $image;
        } else {
            $orders = VorwerkOrder::with('cargoCodes')
                ->where('durum', 2)
                ->whereNotNull('gonderi_takip_no')
                ->where('barcode_printed', 0)
                ->get();

            $images = [];
            foreach ($orders as $item) {
                VorwerkOrder::where('id', $item->id)->update(['barcode_printed' => 1]);
                foreach ($item->cargoCodes as $row) {
                    if (!empty($row->gonderi_barkod_link)) {
                        $image = '<img src="' . env('APP_CDN') . $row->gonderi_barkod_link . '"/>';
                        $images[] = $image;
                    }
                }
            }
            return view('transport.vorwerk_cargo_barcodes', compact('images'));
        }
    }

    /**
     * Vorwer Siparişiten Taşıma Talebi Oluşturur
     *
     * @param Request $request
     * @return void
     */
    public function vorwerkCreateTransportRequest(Request $request)
    {
        //Sipariş bilgilerini al
        try {
            $order = VorwerkOrder::with('consumer')->find($request->order_id);
            $city = City::where('name', $order->teslimat_il)->first();
            $town = Town::where('name', $order->teslimat_ilce)->first();
            // ! BEGIN::Talebe bağlı taşıma talebi oluştur */
            $data["transport_type"] = 3; // Arızalı Ürün Taşıma
            $data["delivery_type"] = 1; // 0 => Teslim Al || 1 => Teslim Et
            $data["reference_number"] = 'DBC' . 10000000 + $request->order_id;
            $data["reference_id"] = $request->order_id;
            $data["contact_name"] = $order->consumer->firstName . ' ' . $order->consumer->lastName;
            $data["contact_number"] = $order->consumer->phone;
            $data["contact_email"] = $order->consumer->email;
            $data["destination_city"] = $city->id ?? 0;
            $data["destination_town"] = $town->id ?? 0;
            $data["destination_address"] = $order->teslimat_adresi1 . ' ' . $order->teslimat_adresi2;

            $transportData = new Request();
            $transportData->replace($data);
            $create = $this->store($transportData, false);
            // ! END::Talebe bağlı taşıma talebi oluştur *

            return $create;
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Kurye Ekranı Resim Yükleme İşlemi
     * Dropzone ile resimler yüklenir
     *
     * @param Request $request
     * @return void
     */
    public function transportImageUpload(Request $request)
    {
        if ($request->file('file')) {
            try {
                //get filename with extension
                //$filenamewithextension = $request->file('file')->getClientOriginalName();
                //get filename without extension
                //$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                //get file extension
                $extension = $request->file('file')->getClientOriginalExtension();
                //filename to store
                $filename = date("YmdHis") . '_' . uniqid() . '.' . $extension;
                $filenametostore = 'transport/' . date("Y-m-d") . '/' . $filename;

                $insert = new TransportRequestFile();
                $insert->transport_request_id = $request->transport_id;
                $insert->file_url = $filenametostore;
                $insert->save();

                if ($insert) {
                    //Upload File to external server
                    $upload = Storage::disk('ftp')->put($filenametostore, fopen($request->file('file'), 'r+'));

                    if ($upload)
                        return response()->json(['success' => ['fileURL' => env('APP_CDN') . $filenametostore, 'file_id' => $insert->id]], 200);
                    else
                        return response()->json(['msg' => 'HATA!'], 500);
                }
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['msg' => $th->getMessage()], 500);
            }
        }
        return response()->json(['msg' => 'Bir dosya eklenmedi'], 500);
    }

    /**
     * Kur ekranı yüklenen resimleri getirir
     * Dropzone ile ekranda listelemek için
     *
     * @return void
     */
    public function getTransportFiles(Request $request)
    {
        $getFiles = TransportRequestFile::where('transport_request_id', $request->transport_id)->get();

        $files = [];
        foreach ($getFiles as $item) {
            $files[] = env('APP_CDN', '') . $item->file_url;
        }

        return $files;
    }

    /**
     * Kurye - Teslim Edilemedi
     * Teslim edilemedi (2030) statüsüne alınır ve log atılır.
     *
     * @param Request $request
     * @return void
     */
    public function transportDeliveryFail(Request $request)
    {
        try {
            DB::transaction(function () use (&$request) {
                TransportRequest::find($request->transport_id)->update(['status_id' => 2030]);
                $reason = DB::table('transport_delivery_fail_reasons')->where('id', $request->deliveryFailReason)->first();
                TransportRequestLog::create([
                    'user_id'       => Auth::user()->id,
                    'activity_id'   => $request->transport_id,
                    'type_key'      => 'delivery_fail',
                    'description'   => 'Teslimat Yapılamadı! => ' . $reason->name,
                ]);
            });

            return response()->json(['success' => 'success'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'error'], 500);
        }
    }

    /**
     * Kurye - Teslimat Tamamlandı
     * Teslim edildi (2040) statüsüne alınır ve log atılır
     *
     * @param Request $request
     * @return void
     */
    public function transportDeliveryComplete(Request $request)
    {
        try {
            DB::transaction(function () use (&$request) {
                TransportRequest::find($request->transport_id)->update(['status_id' => 2040, 'delivery_note' => $request->deliveryNote]);
                $referenceNumber = intval(substr($request->reference_number, 3)) - 10000000;
                switch ($request->type_id) {
                    case 2: //Arızalı Ürün Hizmeti ise
                        $order = PickupRequest::where('id', $referenceNumber)->first();

                        //Arızalı Ürün Hizmeti Evden Eve ise (type=6) ve tamir bitmedi ise ürün servistedir.
                        //Statu = 1035(Servis Sürecinde) olarak ayarlanır Aksi durumlarda sipariş kapanır.
                        if($order->type == 6 && $order->repair == 0){
                            $newStatus = 1035;
                            $logTypeKey = 'service';
                            $logText = 'Servis Sürecinde';
                        } else {
                            $newStatus = 1040;
                            $logTypeKey = 'end';
                            $logText = 'Tamamlandı';
                        }
                        PickupRequest::where('id', $referenceNumber)->update(['status' => $newStatus]);
                        PickupRequestLog::create([
                            'pickup_request_id' => $referenceNumber,
                            'user_id'           => Auth::user()->id,
                            'type_key'          => $logTypeKey,
                            'text'              => $logText
                        ]);
                        break;
                    case 3:// VIP Taşıma Hizmeti ise
                        VorwerkOrder::where('id', $referenceNumber)->update(['durum' => 90]);
                        VorwerkOrderLog::create([
                            'user_id' => Auth::user()->id,
                            'order_id' => $referenceNumber,
                            'type_key' => 'delivered',
                            'description' => 'Teslimat Tamamlandı',
                        ]);
                        break;
                }

                TransportRequestLog::create([
                    'user_id'       => Auth::user()->id,
                    'activity_id'   => $request->transport_id,
                    'type_key'      => 'delivered',
                    'description'   => 'Teslimat Tamamlandı!',
                ]);
            });

            return response()->json(['success' => 'success'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    /**
     * TODO: Yeni taşıma talebi
     * vorwerk order ekranından taşıma talebi oluşturulacak
     * kurye ekranı için taşıma tamamlandı butonundan önce resim yüklemesi zorunlu olacak
     * kurye teslimatı yapamadı ise tekrar planlama ekranına düşecek
     */
}
