<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Product_Category_Detail;
use App\Product_image;
use Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductController extends Controller
{
    public function __construct()
    {
       $this->middleware(['auth:admin','authAdmin:admin']);
    }

	public function index(Request $request){
        /*$products['products'] = Product::orderby('id','desc')->paginate(10);*/
        $products['products'] = DB::table('products')
            ->join('product_category_details', 'products.id','=','product_category_details.product_id')
            ->join('categories', 'categories.id','=','product_category_details.category_id')
            ->select('products.*','categories.category_name')
            ->where('products.deleted_at','=', NULL)
            ->orderby('id','desc')->paginate(10);
        return view('product.home',$products);
	}

    public function create(){
        $categories['categories'] = Category::all();
        return view('product.create', $categories);
    }

    public function store(Request $request){
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
            'product_name' => 'required|unique:products|max:100',
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ],$messages);

    	$product = new Product;
        $category = new Product_Category_Detail;
    	$product->product_name = $request->product_name;
    	$product->price = $request->price;
    	$product->description = $request->description;
    	$product->product_rate = 0;
    	$product->stock = $request->stock;
    	$product->weight = $request->weight;
        $category->category_id = $request->category_id;
    	$product->save();
        $product_id = Product::orderBy('id', 'desc')->first()->id;
        $category->product_id = $product_id;
        $category->save();

    	return redirect('/addImage/'.$product_id);
    }

    public function show($id){
        $where = array('products.id' => $id);
    	$products['products'] = DB::table('products')
            ->join('product_category_details', 'products.id','=','product_category_details.product_id')
            ->join('categories', 'categories.id','=','product_category_details.category_id')
            ->select('products.*','categories.category_name')
            ->where($where)->first();
        $image = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->select('product_images.*')
            ->where($where)->get();
        return view('product.show', compact('products', 'image', 'id'));
    }

    public function edit($id){
        $category = Category::all();
        $products = Product::find($id);
        return view('product.edit', compact('category', 'products', 'id'));
    }

    public function update(Request $request, $id){
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
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ],$messages);

        $update = [
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'weight' => $request->weight,
        ];
        Product::where('id', $id)->update($update);

        $product_id = Product::where('product_name',$request->product_name)->first();

        $update_category = [
            'category_id' => $request->category_id,
        ];

        Product_Category_Detail::where('product_id', $id)->update($update_category);
        return Redirect::to('products');
    }

    public function soft_delete($id){
        $products = Product::find($id);
        $products->delete();
        return Redirect::to('products');
    }

    public function destroy($id){
        Product::where('id', $id)->delete();
        return Redirect::to('products');    
    }

    public function upload($id){
        $products = Product::find($id);
        return view('product.image', compact('products', 'id'));
    }

    public function upload_image(Request $request, $id){
        
        $this->validate($request, [
            'files.*' => 'required',
        ]);

        $files = [];
        foreach ($request->file('files') as $file) {
            if($file->isValid()){
                $nama_image = time()."_".$file->getClientOriginalName();
                $folder = 'image/product_image';
                $file->move($folder,$nama_image);
                $files[] = [
                    'product_id' => $id,
                    'image_name' => $nama_image,
                ];
            }
        }

        Product_image::insert($files);
        return Redirect::to('products');
    }

    public function trash(){
         $products['products'] = DB::table('products')
            ->join('product_category_details', 'products.id','=','product_category_details.product_id')
            ->join('categories', 'categories.id','=','product_category_details.category_id')
            ->select('products.*','categories.category_name')
            ->where('products.deleted_at','!=', NULL)
            ->orderby('id','desc')->paginate(10);

        return view('product.trash', $products);
    }

    public function restore($id){
        $products = Product::onlyTrashed()->where('id',$id);
        $products->restore();
        return Redirect::to('products-trash');
    }

    public function restore_all(){
        $products = Product::onlyTrashed();
        $products->restore();
        return Redirect::to('products-trash');   
    }

    public function delete($id){
        $products = Product::onlyTrashed()->where('id', $id);
        $products->forceDelete();
        return Redirect::to('products-trash');
    }

    public function delete_all($id){
        $products = Product::onlyTrashed();
        $products->forceDelete();
        return Redirect::to('products-trash');
    }
}
