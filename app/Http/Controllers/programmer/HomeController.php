<?php

namespace App\Http\Controllers\programmer;

use App\ProductClick;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:programmer_account');
    }

    /**
     * TOP画面の表示
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programmer = \Auth::user();
        //日別のクリック報酬の取得
        $productClicks= ProductClick::query()
            ->select(\DB::raw('sum(click_price) as price, DATE_FORMAT(product_clicks.created_at, \'%Y%-%m%-%d\') as date'))
            ->join('curriculums','curriculum_id','=','curriculums.id')
            ->join('products','products.id','=','curriculums.product_id')
            ->groupBy(\DB::raw('DATE_FORMAT(product_clicks.created_at, \'%Y%-%m%-%d\')'))
            ->where('curriculums.programmer_id','=',$programmer->id)
            ->get();

        $data = array();
        $labels = array();

        //チャートにセットするために整形
        foreach ($productClicks as $productClick){
            $labels[] = $productClick->date;
            $data[]   = ( int )$productClick->price;
        }

        //jsで使うためにjson型にエンコード
        $labels = json_encode($labels);
        $data = json_encode($data);

        return view('programmer.top',compact('data','labels'));
    }

    /**
     * ajaxで報酬のチャートデータ取得
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax(Request $request){
        $programmer = \Auth::user();
        //dateのタイプ取得
        $date = $request->date;
        //タイプ毎に取得するデータの分岐
        switch ($date){
            case 'year':
                //1年単位のデータの取得
                $type = '年';
                $productClicks= ProductClick::query()
                    ->select(\DB::raw('sum(click_price) as price, DATE_FORMAT(product_clicks.created_at, \'%Y\') as date'))
                    ->join('curriculums','curriculum_id','=','curriculums.id')
                    ->join('products','products.id','=','curriculums.product_id')
                    ->groupBy(\DB::raw('DATE_FORMAT(product_clicks.created_at, \'%Y\')'))
                    ->where('curriculums.programmer_id','=',$programmer->id)
                    ->get();
                break;
            case 'month':
                //１月単位のデータの取得
                $type = '月';
                $productClicks= ProductClick::query()
                    ->select(\DB::raw('sum(click_price) as price, DATE_FORMAT(product_clicks.created_at, \'%Y%-%m\') as date'))
                    ->join('curriculums','curriculum_id','=','curriculums.id')
                    ->join('products','products.id','=','curriculums.product_id')
                    ->groupBy(\DB::raw('DATE_FORMAT(product_clicks.created_at, \'%Y%-%m\')'))
                    ->where('curriculums.programmer_id','=',$programmer->id)
                    ->get();
                break;
            case 'day':
                //１日単位の日にちの取得
                $productClicks= ProductClick::query()
                    ->select(\DB::raw('sum(click_price) as price, DATE_FORMAT(product_clicks.created_at, \'%Y%-%m%-%d\') as date'))
                    ->join('curriculums','curriculum_id','=','curriculums.id')
                    ->join('products','products.id','=','curriculums.product_id')
                    ->groupBy(\DB::raw('DATE_FORMAT(product_clicks.created_at, \'%Y%-%m%-%d\')'))
                    ->where('curriculums.programmer_id','=',$programmer->id)
                    ->get();
                break;
        }

        $data = array();
        $labels = array();

        foreach ($productClicks as $productClick){
            $labels[] = $productClick->date;
            $data[]   = ( int )$productClick->price;
        }
        //チャートにセットするために整形
        $date = array(
            'labels' => $labels,
            'datasets'=>array(
                'label'=>'１'.$type.'毎の報酬集計(円)',
                'data'=>$data
            )
        );
        //Json型にエンコードしてリターン
        return \Response::json($date);
    }
}
