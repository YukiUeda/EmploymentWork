<?php

namespace App\Http\Controllers\company;

use App\Curriculum;
use App\Http\Controllers\Controller;
use App\Http\Requests\company\ProductPluginRequest;
use App\Http\Requests\company\ProductRequest;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * 商品追加ページ表示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('company.product_update');
    }

    /**
     * プラグイン商品追加ページ表示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pluginIndex(){
        $school = \Auth::user();
        $id     = $school->id;

        //商品情報取得
        $product = Product::query()->where('plugin_id','=','0')->where('company_id','=',$id)->get();
        return view('company.product_plugin_create',compact('product'));
    }

    /**
     * 商品追加処理
     * @param ProductRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productCreate(ProductRequest $request){
        //画像データの取得
        $file_name = $request->file('image');

        //切り取り用の位置情報
        $x = $request->x;
        $y = $request->y;
        $h = $request->h;
        $w = $request->w;
        //画像の一時ファイルの場所を取得
        $img = Image::make($file_name->getRealPath());
        //画像の切り抜き
        $img->crop($w,$h,$x,$y);
        //ファイルの名前をランダム生成
        $file_name = str_random(10);
        //保存ファイルの場所指定
        $file_path = '/images/' . 'product/' . \Auth::user()->id . '/' . $file_name .  '.png';
        //ファイルの存在チェック
        \File::exists(public_path() . '/images/' .'product/'. \Auth::user()->id) or \File::makeDirectory(public_path() . '/images/' . 'product/' . \Auth::user()->id);
        //画像の保存
        $img->save(public_path() . $file_path);

        //商品情報をデータベースに保存
        $product = new Product();
        $product->company_id = \Auth::user()->id;
        $product->name       = $request->name;
        $product->url        = $request->url;
        $product->price      = $request->price;
        $product->image      = $file_path;
        $product->click_price= $request->click_price;
        $product->save();

        return view('company.product_update');
    }


    public function productPluginCreate(ProductPluginRequest $request){
        //画像データの取得
        $file_name = $request->file('image');

        //切り取り用の位置情報
        $x = $request->x;
        $y = $request->y;
        $h = $request->h;
        $w = $request->w;

        //画像の一時ファイルの場所を取得
        $img = Image::make($file_name->getRealPath());
        //画像の切り抜き
        $img->crop($w,$h,$x,$y);
        //ファイルの名前をランダム生成
        $file_name = str_random(10);
        //保存ファイルの場所指定
        $file_path = '/images/' . 'product/' . \Auth::user()->id . '/' . $file_name .  '.png';
        //ファイルの存在チェック
        \File::exists(public_path() . '/images/' .'product/'. \Auth::user()->id) or \File::makeDirectory(public_path() . '/images/' . 'product/' . \Auth::user()->id);
        //画像の保存
        $img->save(public_path() . $file_path);

        //商品情報をデータベースに保存
        $product = new Product();
        $product->company_id = \Auth::user()->id;
        $product->plugin_id  = $request->product;
        $product->name       = $request->name;
        $product->url        = $request->url;
        $product->price      = $request->price;
        $product->image      = $file_path;
        $product->click_price= $request->click_price;
        $product->save();
        
        return view('company.product_update');
    }

    public function product(){
        $company = \Auth::user();
        $id = $company->id;

        $products = Product::query()->where('company_id',$id)->paginate('10');

        return \view('company.product',compact('products'));
    }

    public function chart(Request $request){
        $id = $request->id;
        $product = Product::query()->find($id);

        $curriculums = Curriculum::query()->select(DB::raw('subject,count(*) as data'))
            ->where('product_id',$id)->groupBy('subject')->get();

        \Debugbar::addMessage($curriculums);
        $data = array();
        $data['name'] = $product->name;
        foreach ($curriculums as $curriculum){
            $data['data'][$curriculum->subject] = $curriculum->data;
        }

        return \Response::json($data);
    }
}
