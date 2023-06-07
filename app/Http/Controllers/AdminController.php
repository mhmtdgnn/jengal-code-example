<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceBank;
use App\Models\ServiceDocument;
use App\Models\BpmRule;
use App\Models\Product;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function services()
    {
        $services = Service::where('servis_durumu', 1)->get();
        return view('superadmin.services', compact('services'));
    }

    public function newService()
    {
        return view('superadmin.new-service');
    }

    public function createService(Request $request)
    {
        if ($request->servis_durumu == 'on') {
            $servis_durumu = 1;
        } else {
            $servis_durumu = 0;
        }

        $servis = new Service();
        $servis->servis_adi = $request->servis_adi;
        $servis->sirket_turu = $request->sirket_turu;
        $servis->mail = $request->mail;
        $servis->adres = $request->adres;
        $servis->telefon = $request->telefon;
        $servis->satici_kodu = $request->satici_kodu;
        $servis->odeyen_kodu = $request->odeyen_kodu;
        $servis->vergi_dairesi = $request->vergi_dairesi;
        $servis->vergi_numarasi = $request->vergi_numarasi;
        $servis->servis_durumu = $servis_durumu;
        $servis->son_vize_tarihi = $request->son_vize_tarihi;
        $servis->save();

        return back()->with('msg', 'Servis başarıyla kaydedilmiştir');
    }

    public function editService($id)
    {
        $service = Service::with(
            [
                'documents' => function ($q) {
                    $q->orderby('type', 'desc');
                },
                'banks'
            ]
        )->find($id);
        return view('superadmin.edit-service', compact('service'));
    }

    public function addBank(Request $request)
    {
        $banka = new ServiceBank();
        $banka->service_id = $request->servis_id;
        $banka->isim = $request->name_surname;
        $banka->banka = $request->banka;
        $banka->iban = $request->iban;
        $banka->save();

        $id = $banka->id;

        $c = null;
        $c .= '<tr id="row'.$id.'"><td>' . $request->servis_id . '</td><td>' . $request->name_surname . '</td><td>' . $request->banka . '</td><td>' . $request->iban . '</td>';
        $c .= '<td><button type="button" name="remove" id="'.$id.'" class="btn btn-danger btn-sm px-3 py-1 me-2 mb-2 btn_remove">SİL</button></td></tr>';
        return $c;
    }

    public function removeBank()
    {
        ServiceBank::destroy($_GET['id']);
    }

    public function updateService(Request $request)
    {
        if ($request->servis_durumu == 'on') {
            $servis_durumu = 1;
        } else {
            $servis_durumu = 0;
        }

        $servisId = $request->servis_id;
        $servis = Service::find($servisId);
        $servis->servis_adi = $request->servis_adi;
        $servis->sirket_turu = $request->sirket_turu;
        $servis->mail = $request->mail;
        $servis->adres = $request->adres;
        $servis->telefon = $request->telefon;
        $servis->satici_kodu = $request->satici_kodu;
        $servis->odeyen_kodu = $request->odeyen_kodu;
        $servis->servis_tipi = $request->servis_tipi;
        $servis->iscilik_kategori = $request->iscilik_kategori;
        $servis->iskonto_kategori = $request->iskonto_kategori;
        $servis->kategori_servis_tipi = $request->kategori_servis_tipi;
        $servis->etiketler = (isset($request->etiketler)) ? implode(', ', array_column(json_decode($request->etiketler), 'value')) : '';
        $servis->vergi_dairesi = $request->vergi_dairesi;
        $servis->vergi_numarasi = $request->vergi_numarasi;
        $servis->servis_durumu = $servis_durumu;
        $servis->son_vize_tarihi = $request->son_vize_tarihi;
        $servis->save();

        if (isset($request->servisImageYukle)) {
            foreach ($request->servisImageYukle as $siy) {
                $extension = explode('/', mime_content_type($siy))[1];
                $image = str_replace('data:image/'.$extension.';base64,', '', $siy);
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(10).'.'.$extension;
                $dokuman = ServiceDocument::updateOrCreate(
                    [
                        'service_id' => $servisId,
                        'type'      => 'servis_gorseli'
                    ],
                    [
                        'service_id' => $servisId,
                        'type'      => 'servis_gorseli',
                        'image'     => $imageName
                    ]
                );
                Storage::disk('servis')->put($servisId.'/'.$imageName, base64_decode($image));
            }
        }

        if (isset($request->vergiYukle)) {
            $extension = explode('/', mime_content_type($request->vergiYukle))[1];
            $image = str_replace('data:image/'.$extension.';base64,', '', $request->vergiYukle);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.$extension;
            $dokuman = ServiceDocument::updateOrCreate(
                [
                    'service_id' => $servisId,
                    'type'      => 'vergi'
                ],
                [
                    'service_id' => $servisId,
                    'type'      => 'vergi',
                    'image'     => $imageName
                ]
            );
            Storage::disk('servis')->put($servisId.'/'.$imageName, base64_decode($image));
        }

        if (isset($request->ruhsatYukle)) {
            $extension = explode('/', mime_content_type($request->ruhsatYukle))[1];
            $image = str_replace('data:image/'.$extension.';base64,', '', $request->ruhsatYukle);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.$extension;
            $dokuman = ServiceDocument::updateOrCreate(
                [
                    'service_id' => $servisId,
                    'type'      => 'ruhsat'
                ],
                [
                    'service_id' => $servisId,
                    'type'      => 'ruhsat',
                    'image'     => $imageName
                ]
            );
            Storage::disk('servis')->put($servisId.'/'.$imageName, base64_decode($image));
        }

        if (isset($request->imzaYukle)) {
            $extension = explode('/', mime_content_type($request->imzaYukle))[1];
            $image = str_replace('data:image/'.$extension.';base64,', '', $request->imzaYukle);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.$extension;
            $dokuman = ServiceDocument::updateOrCreate(
                [
                    'service_id' => $servisId,
                    'type'      => 'imza'
                ],
                [
                    'service_id' => $servisId,
                    'type'      => 'imza',
                    'image'     => $imageName
                ]
            );
            Storage::disk('servis')->put($servisId.'/'.$imageName, base64_decode($image));
        }

        if (isset($request->sicilYukle)) {
            $extension = explode('/', mime_content_type($request->sicilYukle))[1];
            $image = str_replace('data:image/'.$extension.';base64,', '', $request->sicilYukle);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.$extension;
            $dokuman = ServiceDocument::updateOrCreate(
                [
                    'service_id' => $servisId,
                    'type'      => 'sicil'
                ],
                [
                    'service_id' => $servisId,
                    'type'      => 'sicil',
                    'image'     => $imageName
                ]
            );
            Storage::disk('servis')->put($servisId.'/'.$imageName, base64_decode($image));
        }

        if (isset($request->faaliyetYukle)) {
            $extension = explode('/', mime_content_type($request->faaliyetYukle))[1];
            $image = str_replace('data:image/'.$extension.';base64,', '', $request->faaliyetYukle);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.$extension;
            $dokuman = ServiceDocument::updateOrCreate(
                [
                    'service_id' => $servisId,
                    'type'      => 'faaliyet'
                ],
                [
                    'service_id' => $servisId,
                    'type'      => 'faaliyet',
                    'image'     => $imageName
                ]
            );
            Storage::disk('servis')->put($servisId.'/'.$imageName, base64_decode($image));
        }

        if (isset($request->tseYukle)) {
            $extension = explode('/', mime_content_type($request->tseYukle))[1];
            $image = str_replace('data:image/'.$extension.';base64,', '', $request->tseYukle);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.$extension;
            $dokuman = ServiceDocument::updateOrCreate(
                [
                    'service_id' => $servisId,
                    'type'      => 'tse'
                ],
                [
                    'service_id' => $servisId,
                    'type'      => 'tse',
                    'image'     => $imageName
                ]
            );
            Storage::disk('servis')->put($servisId.'/'.$imageName, base64_decode($image));
        }
        return redirect(route('superAdmin.edit-service', $servisId));
    }

    public function bpmRule()
    {
        $sapCodes = Product::select('product_code', 'product_name')
            ->whereIn('iris_kategori', ['B', 'C', 'J', 'K', 'L', 'M', 'N'])
            ->whereNotNull('product_name')
            ->get();

        $families = Product::select('level_1_fam', 'level_1_fam_desc')
            ->groupBy('level_1_fam', 'level_1_fam_desc')
            ->whereIn('iris_kategori', ['B', 'C', 'J', 'K', 'L', 'M', 'N'])
            ->whereNotNull('level_1_fam_desc')
            ->get();

        $partSapCodes = Part::select('parts_sap_code', 'parts_product_name')
            ->groupBy('parts_sap_code', 'parts_product_name')
            ->get();

        $activeBPMRules = BpmRule::where('status', 1)->orderBy('rank', 'ASC')->get();
        $passiveBPMRules = BpmRule::where('status', 0)->orderBy('rank', 'ASC')->get();

        return view('superadmin.bpm_rule', compact('sapCodes', 'families', 'partSapCodes', 'activeBPMRules', 'passiveBPMRules'));
    }

    public function bpmRuleCreate(Request $request)
    {
        try {
            $rule = new BpmRule();
            $rule->title = $request->title;
            $rule->rules = json_encode($request->all());
            $rule->rank = 1;
            $rule->status = 1;
            $rule->save();

            return back()->with('msg', 'BPM kuralı başarıyla oluşturulmuştur');
        } catch (\Throwable $th) {
            return back()->with('msg', 'BPM kuralı oluşturulurken bir sorunla karşılaşıldı');
        }
    }

    public function bpmRuleUpdateRank(Request $request)
    {
        $data = json_decode(stripslashes($request->data));
        $rules = BpmRule::all();

        foreach ($rules as $rule) {
            $rule->timestamps = false;
            $id = $rule->id;

            foreach ($data as $item) {
                if ($item->id == $id) {
                    $rule->update(['rank' => $item->rank]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'İşlem başarı ile gerçekleşmiştir.']);
    }

    public function bpmRuleUpdateStatus(Request $request)
    {
        BpmRule::where('id', $request->id)->update(['status' => $request->val]);
    }
}
