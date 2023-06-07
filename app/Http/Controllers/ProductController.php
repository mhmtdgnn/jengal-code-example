<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    // Fetch records
    public function products(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $products = Product::orderby('product_name', 'asc')->select('id', 'product_code', 'product_name')->limit(5)->get();
        } else {
            $products = DB::table('product_search_view')->orderby('product_name', 'asc')->select('id', 'product', 'product_code', 'product_name', 'company_name')
                ->where('product', 'like', '%' . $search . '%')
                ->limit(5)
                ->get();
        }

        $response = [];
        foreach ($products as $product) {
            $response[] = array(
                "id" => $product->id,
                "text" => $product->product_name,
                "company" => $product->company_name
            );
        }
        return response()->json($response);
    }
}
