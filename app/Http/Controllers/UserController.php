<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use App\Cart;
use App\Discount;
use DB;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')->orderby('products.id', 'desc')->paginate(9);
        $count_carts = Cart::where('user_id', '=', Auth::user()->id)->where('carts.status', '=', 'notyet')->count('id');
        $product_carts = DB::table('carts')
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->join('users', 'users.id', '=', 'carts.user_id')
                    ->select('products.*', 'carts.qty', 'carts.id AS cart_id')
                    ->where('carts.deleted_at', '=', null)
                    ->where('carts.user_id', '=', Auth::user()->id)->get();
        $product_images = DB::table('product_images')->select('product_images.*')->get();
        $categories = DB::table('categories')->select('categories.*')->get();
        $discounts = Discount::where('discounts.end', '>', date('Y-m-d'))->get();
        return view('user.home', compact('products', 'count_carts', 'product_carts', 'product_images', 'categories', 'discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $images = DB::table('product_images')
                ->join('products', 'products.id', '=', 'product_images.product_id')
                ->select('product_images.image_name')
                ->where('products.id', '=', $id)->get();
        $sum_image = DB::table('product_images')->where('product_images.product_id', '=', $id)
                            ->count('product_images.id');
        $count_carts = Cart::where('user_id', '=', Auth::user()->id)->where('carts.status', '=', 'notyet')->count('id');
        $product_carts = DB::table('carts')
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->join('users', 'users.id', '=', 'carts.user_id')
                    ->select('products.*', 'carts.qty', 'carts.id AS cart_id')
                    ->where('carts.deleted_at', '=', null)
                    ->where('carts.user_id', '=', Auth::user()->id)->get();
        $image_carts = DB::table('product_images')->select('product_images.*')->get();
        $categories = DB::table('categories')->select('categories.*')->get();
        $discount = Discount::where('id_product', '=', $id)->orderby('end', 'desc')->first();
        return view('user.product_detail', compact('product', 'images', 'sum_image', 'id', 'count_carts', 'product_carts', 'image_carts', 'categories', 'discount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function invoice($id){
        $transactions = DB::table('transactions')->select('transactions.*')->where('transactions.user_id', '=', $id)
        ->orderby('id', 'desc')->paginate(10);
        return view('user.invoice', compact('transactions'));
    }

    public function getInvoice($id){
        $transaction = DB::table('transactions')->select('transactions.*')->where('transactions.id', '=', $id)->first();
        $products = DB::table('transaction_details')->join('products', 'products.id', '=', 'transaction_details.product_id')
                    ->select('transaction_details.*', 'products.weight', 'products.product_name')
                    ->where('transaction_details.transaction_id', '=', $transaction->id)->get();
        return view('user.invoice_detail', compact('transaction', 'products'));
    }

    public function search_category(Request $request){
        $product_images = DB::table('product_images')->select('product_images.*')->get();
        $categories = DB::table('categories')->select('categories.*')->get();
        $discounts = Discount::where('discounts.end', '>', date('Y-m-d'))->get();
        $products = DB::table('products')
                    ->join('product_category_details', 'products.id', 'product_category_details.product_id')
                    ->join('categories', 'categories.id', 'product_category_details.category_id')
                    ->select('products.*')->where('products.category', '=', $request->kind)
                    ->where('categories.id', '=', $request->category)
                    ->where('product_category_details.deleted_at', '=', NULL)
                    ->orderby('products.id', 'desc')->paginate(9);
        return view('user.searching_tag', compact('products', 'product_images', 'categories', 'discounts'));
    }
}
