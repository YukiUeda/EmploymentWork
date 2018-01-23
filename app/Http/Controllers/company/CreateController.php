<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\CompanyAccount;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\company\CompanyRequest;



class CreateController extends Controller
{
    /**
     * 会社アカウント作成ページ
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('company.create');
    }

    /**
     * 会社アカウント作成処理
     * @param CompanyRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CompanyRequest $request){
        $company = new CompanyAccount();
        $company->name     = $request->name;
        $company->email    = $request->email;
        $company->password = Hash::make($request->password);
        $company->save();
        return $this->index();
    }
}
