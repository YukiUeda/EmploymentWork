<?php

namespace App\Http\Controllers\programmer;

use App\Curriculum;
use App\CurriculumContent;
use App\CurriculumObjective;
use App\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurriculumController extends Controller
{
    public function index(){
        $company = \Auth::user();
        $curriculums = Curriculum::select(['curriculums.*','products.name'])
            ->join('products','products.id','product_id')
            ->where('programmer_id','=',$company->id)
            ->orderBy('auth')
            ->paginate(15);

        return view('programmer.curriculum',compact('curriculums'));
    }
}
