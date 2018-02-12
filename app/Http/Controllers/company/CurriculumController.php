<?php

namespace App\Http\Controllers\company;

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
            ->where('company_id','=',$company->id)
            ->paginate(15);

        return view('company.curriculum',compact('curriculums'));
    }

    /**
     * 詳細画面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id){
        $curriculum = Curriculum::find($id);
        if(!empty($curriculum)){
            $product  = product::find($curriculum->product_id);
            $contents = CurriculumContent::where('curriculum_id',$id)->get();
            $objects  = CurriculumObjective::join('objectives','objective_id','=','objectives.id')->where('curriculum_id',$id)->get();
            return view('company.curriculum_content',compact('curriculum','objects','contents','product'));
        }else{
            return $this->index();
        }
    }

    public function auth($id){
        $company = \Auth::user();
        $cId = $company->id;

        $exist = Curriculum::query()
            ->join('products','products.id','=','product_id')
            ->where('products.company_id','=',$cId)
            ->where('curriculums.id','=',$id)
            ->exists();
        if($exist){
            $curriculum = Curriculum::find($id);
            if($curriculum->auth == 1){
                $curriculum->auth = 0;
            }else{
                $curriculum->auth = 1;
            }
            $curriculum->update();
        }

        return $this->index();
    }
}
