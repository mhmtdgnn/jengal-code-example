<?php

namespace App\Http\Controllers;

use App\Models\ECommerceOrder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ECommerceOrderImport;
use App\Jobs\ECommerceOrderManagement;

class ECommerceController extends Controller
{
    public function ecommerceOrderList(Request $request)
    {
        $title = "ECommerce Sipariş Listesi";

        $orders = ECommerceOrder::orderBy('created_at', 'DESC')->paginate(30);

        return view('transport.ecommerce_order_list', compact('title', 'orders'));
    }

    public function ecommerceOrderImport(Request $request)
    {
        Excel::import(new ECommerceOrderImport(), $request->file('importFile'));
        return back()->with('msg', 'Sipariş Listesi Başarıyla İçe Aktarılmıştır.');
    }

    public function ecommerceOrderPreview(Request $request)
    {
        $order = ECommerceOrder::with(
            [
                'detail' => function ($q) {
                    $q->select('ecommerce_order_details.*', 'p.product_code', 'p.product_name');
                    $q->leftJoin('products as p', 'ecommerce_order_details.product_id', '=', 'p.id');
                    $q->orderby('p.product_code', 'asc');
                }
            ]
        )->find($request->id);

        return view('transport.partials.modals.ecommerce-detail-modal', compact('order'));
    }

    public function synchronizeECommerceOrder()
    {
        $orders = ECommerceOrder::where('durum', 1)->get();

        foreach ($orders as $item) {
            $data['method'] = 'synchronize';
            $data['order'] = $item;
            ECommerceOrderManagement::dispatchNow($data);
        }

        return back()->with('msg', 'Siparişler Horoza aktarılmıştır.');
    }
}
