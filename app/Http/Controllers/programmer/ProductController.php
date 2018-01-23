<?php

namespace App\Http\Controllers\programmer;

use App\Curriculum;
use App\CurriculumContent;
use App\CurriculumObjective;
use App\Http\Controllers\Controller;
use App\Http\Requests\programmer\CurriculumRequest;
use Intervention\Image\Facades\Image;
use App\Objective;
use App\product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    /**
     * カリキュラムを作る時の商品一覧を取得するメソッド
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function curriculum(){
        //商品一覧取得
        $products = DB::table('products')->join('company_accounts','products.company_id','=','company_accounts.id')
            ->select('products.id as pid','price','click_price','products.name as pname','company_accounts.name as cname','image','url')->paginate(10);

        return view('programmer.product',compact('products'));
    }

    /**
     * カリキュラム作成画面表示メソッド
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function curriculumSetting($id){
        //商品IDの存在チェック
        $product = Product::find($id);
        if($product){
            //存在していたら作成画面表示
            return view('programmer.curriculum_create',compact('product'));
        }
        //存在してなかったら商品一覧表示
        return $this->curriculum();
    }

    /**
     * カリキュラムの追加処理
     * @param CurriculumRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function curriculumCreate(CurriculumRequest $request, $id){
        //商品の存在チェック
        $product = Product::find($id);
        if($product){
            $programmer = \Auth::user();

            //ファイルの取得
            $file_name = $request->file('image');

            //各リクエストデータの取得
            $time        = $request->time;
            $grade       = $request->grade;
            $title       = $request->title;
            $description = $request->description;
            $subject     = $request->subject;
            $contents    = $request->contents;
            $images      = $request->file('images');
            $objectives  = $request->objective;
            $xs          = $request->x;
            $ys          = $request->y;
            $ws          = $request->w;
            $hs          = $request->h;

            //一時保存しているファイルデータ取得
            $img = Image::make($file_name->getRealPath());
            //画像の切り取り
            $img->crop($ws[0],$hs[0],$xs[0],$ys[0]);
            //ファイルデータの取得
            $file_name = str_random(10);
            //ファイルパスの取得
            $file_path = '/images/' . 'curriculum/' . \Auth::user()->id . '/' . $file_name .  '.png';
            //ファイルの存在チェック
            \File::exists(public_path() . '/images/' .'curriculum/'. \Auth::user()->id) or \File::makeDirectory(public_path() . '/images/' . 'curriculum/' . \Auth::user()->id);
            //ファイル保存
            $img->save(public_path() . $file_path);

            //カリキュラムのデータ保存
            $curriculum = new Curriculum;
            $curriculum->programmer_id     = $programmer->id;
            $curriculum->product_id        = $id;
            $curriculum->time              = $time;
            $curriculum->school_grade      = $grade;
            $curriculum->title             = $title;
            $curriculum->description       = $description;
            $curriculum->curriculum_image  = $file_path;
            $curriculum->subject           = $subject;
            $curriculum->save();

            $curriculumId = $curriculum->id;

            //目標が設定されているか？
            if(isset($objectives)) {
                foreach ($objectives as $objective) {
                    //目標の存在チェック
                    $object = Objective::query()->where('name', '=', $objective)->exists();
                    if ($object) {
                        //目標をカリキュラムに追加
                        $object = Objective::query()->where('name', '=', $objective)->get();
                        $curriculum_objective = new CurriculumObjective;
                        $curriculum_objective->objective_id = $object[0]->id;
                        $curriculum_objective->curriculum_id = $curriculumId;
                        $curriculum_objective->save();
                    } else {
                        //目標を追加
                        $object = new Objective();
                        $object->name = $objective;
                        $object->save();
                        //目標をカリキュラムに追加
                        $curriculum_objective = new CurriculumObjective();
                        $curriculum_objective->objective_id = $object->id;
                        $curriculum_objective->curriculum_id = $curriculumId;
                        $curriculum_objective->save();
                    }
                }
            }
            $i = 0;
            foreach ($contents as $content){
                //コンテンツの画像取得
                $image = $images[$i];
                //画像のパス取得
                $img = Image::make($image->getRealPath());
                //画像の切り抜き
                $img->crop($ws[$i+1],$hs[$i+1],$xs[$i+1],$ys[$i+1]);
                //画像の名前の生成
                $file_name = str_random(10);
                //ファイルパス取得
                $file_path = '/images/' . 'content/' . \Auth::user()->id . '/' . $file_name .  '.png';
                //ファイルの存在チェック存在してなかったら作成
                \File::exists(public_path() . '/images/' .'content/'. \Auth::user()->id) or \File::makeDirectory(public_path() . '/images/' . 'content/' . \Auth::user()->id);
                //画像保存
                $img->save(public_path() . $file_path);
                //コンテンツ作成
                $curriculumContent = new CurriculumContent();
                $curriculumContent->curriculum_id = $curriculumId;
                $curriculumContent->contents      = $content;
                $curriculumContent->image         = $file_path;
                $curriculumContent->save();

                $i++;
            }

            return view('programmer.curriculum_create',compact('product'));
        }
        return view('programmer.top');
    }

    public function autoComplete(){
        //一覧取得
        $objectives = Objective::all();
        $objective = array();
        //autoComplete向けにデータ整形
        foreach ($objectives as $value){
            $name = $value->name;
            $objective[$name] = '';
        }
        return \Response::json($objective);
    }
}
