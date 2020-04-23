<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;

class DiscountController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:admin','authAdmin:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts['discounts'] = DB::table('discounts')
                                    ->join('products', 'products.id', '=', 'discounts.id_product')
                                    ->join('product_category_details', 'products.id', '=', 'product_category_details.product_id')
                                    ->select('discounts.*', 'products.product_name', 'product_category_details.category')
                                    ->where('discounts.deleted_at', '=', NULL)
                                    ->orderby('discounts.id', 'desc')->paginate(5);
        return view('discount.home', $discounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products['products'] = DB::table('products')
                            ->join('product_category_details', 'products.id', '=', 'product_category_details.product_id')
                            ->select('products.*', 'product_category_details.category')
                            ->get();
        return view('discount.create', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute Wajib Diisi',
            'max' => ':attribute Harus Diisi maksimal :max karakter',
            'min' => ':attribute Harus Diisi minimum :min karakter',
            'string' => ':attribute Hanya Diisi Huruf dan Angka',
            'confirmed' => ':attribute Konfirmasi Password Salah',
            'unique' => ':attribute Username sudah ada',
            'email' => ':attribute Format Email Salah',
            'numeric' => ':attribute Data Harus Angka',
        ];

        $this->validate($request,[
            'id_product' => 'required',
            'percentage' => 'required|numeric',
        ],$messages);

        $discounts = new Discount;
        $discounts->id_product = $request->id_product;
        $discounts->percentage = $request->percentage;
        $discounts->start  = $request->start;
        $discounts->end = $request->end;
        $discounts->save();
        return Redirect::to('discounts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = DB::table('products')
                                    ->join('product_category_details', 'products.id', '=', 'product_category_details.product_id')
                                    ->select('products.*', 'product_category_details.category')
                                    ->get();
        $discount = Discount::find($id);
        return view('discount.edit', compact('products', 'discount', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute Wajib Diisi',
            'max' => ':attribute Harus Diisi maksimal :max karakter',
            'min' => ':attribute Harus Diisi minimum :min karakter',
            'string' => ':attribute Hanya Diisi Huruf dan Angka',
            'confirmed' => ':attribute Konfirmasi Password Salah',
            'unique' => ':attribute Username sudah ada',
            'email' => 'attribute Format Email Salah',
        ];

        $this->validate($request,[
            'id_product' => 'required',
            'percentage' => 'required|numeric'
        ],$messages);

        $update = [
            'id_product' => $request->id_product,
            'percentage' => $request->percentage,
            'start' => $request->start,
            'end' => $request->end,
        ];
        Discount::where('id', $id)->update($update);
        return Redirect::to('discounts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        //
    }

    public function soft_delete($id){
        $discounts = Discount::find($id);
        $discounts->delete();
        return Redirect::to('discounts');
    }
}
