<?php

namespace App\Http\Controllers\programmer;

use App\Http\Controllers\Controller;
use App\Http\Requests\programmer\ProgrammerRequest;
use App\ProgrammerAccount;
use Illuminate\Support\Facades\Hash;

class ProgrammerCreateController extends Controller
{
    /**
     * 初期起動時に動くメッソド
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('programmer.create');
    }

    /**
     * プログラマー作成
     * @param ProgrammerRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ProgrammerRequest $request){
        //入力された情報の設定
        $school = new ProgrammerAccount();
        $school->name             = $request->post('name');
        $school->password         = Hash::make($request->post('password'));
        $school->email = $request->post('email');
        //インサート
        $school->save();
        //ページ移動
        return view('programmer.create');
    }
}
