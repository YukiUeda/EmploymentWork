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
            ->orderBy('date','desc')
            ->limit(30)
            ->get();

        $labels = array();
        $date = null;
        foreach ($productClicks as $productClick){
            if(empty($date)){
                $date = $productClick->date;
            }
            else{
                if($date != $productClick->date){
                    for($i = 1;0 == 0;$i++){
                        if(count($labels) > 30 ){
                            break;
                        }
                        if(date("Y-m-d",strtotime("-$i day $date")) == $productClick->date){
                            break;
                        }
                        $labels[] = date("Y-m-d",strtotime("-$i day $date")) ;
                        $data[]   = 0;
                    }
                }
            }
            if(count($labels) > 30 ){
                break;
            }
            $date = $productClick->date;
            $labels[] = $productClick->date;
            $data[]   = ( int )$productClick->price;
        }
        array_multisort($labels,SORT_ASC,$data);

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
        $data = array();
        $labels = array();
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
                    ->orderBy('date','desc')
                    ->limit(30)
                    ->get();

                $date = null;
                foreach ($productClicks as $productClick){
                    if(empty($date)){
                        $date = $productClick->date;
                    }
                    else{
                        if($date != $productClick->date){

                            for($i = 1;0 == 0;$i++){
                                if(count($labels) > 30 ){
                                    break;
                                }
                                if($date - 1 == $productClick->date){
                                    break;
                                }
                                $labels[] = $date - 1 ;
                                $data[]   = 0;
                            }
                        }
                    }
                    if(count($labels) > 30 ){
                        break;
                    }
                    $date = $productClick->date;
                    $labels[] = $productClick->date;
                    $data[]   = ( int )$productClick->price;
                }
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
                    ->orderBy('date','desc')
                    ->limit(30)
                    ->get();


                $date = null;
                foreach ($productClicks as $productClick){
                    if(empty($date)){
                        $date = $productClick->date;
                    }
                    else{
                        if($date != $productClick->date){
                            for($i = 1;0 == 0;$i++){
                                if(count($labels) > 30 ){
                                    break;
                                }
                                if(date("Y-m",strtotime("-$i month $date")) == $productClick->date){
                                    break;
                                }
                                $labels[] = date("Y-m",strtotime("-$i month $date")) ;
                                $data[]   = 0;
                            }
                        }
                    }
                    if(count($labels) > 30 ){
                        break;
                    }
                    $date = $productClick->date;
                    $labels[] = $productClick->date;
                    $data[]   = ( int )$productClick->price;
                }
                break;
            case 'day':
                //１日単位の日にちの取得
                $type = '日';
                $productClicks= ProductClick::query()
                    ->select(\DB::raw('sum(click_price) as price, DATE_FORMAT(product_clicks.created_at, \'%Y%-%m%-%d\') as date'))
                    ->join('curriculums','curriculum_id','=','curriculums.id')
                    ->join('products','products.id','=','curriculums.product_id')
                    ->groupBy(\DB::raw('DATE_FORMAT(product_clicks.created_at, \'%Y%-%m%-%d\')'))
                    ->where('curriculums.programmer_id','=',$programmer->id)
                    ->orderBy('date','desc')
                    ->limit(30)
                    ->get();

                $date = null;
                foreach ($productClicks as $productClick){
                    if(empty($date)){
                        $date = $productClick->date;
                    }
                    else{
                        if($date != $productClick->date){
                            for($i = 1;0 == 0;$i++){
                                if(count($labels) > 30 ){
                                    break;
                                }
                                if(date("Y-m-d",strtotime("-$i day $date")) == $productClick->date){
                                    break;
                                }
                                $labels[] = date("Y-m-d",strtotime("-$i day $date")) ;
                                $data[]   = 0;
                            }
                        }
                    }
                    if(count($labels) > 30 ){
                        break;
                    }
                    $date = $productClick->date;
                    $labels[] = $productClick->date;
                    $data[]   = ( int )$productClick->price;
                }
                break;
        }

        array_multisort($labels,SORT_ASC,$data);

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
