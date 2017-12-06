<?php

namespace App\Http\Controllers;

use App\BasicSetting;
use App\GeneralSetting;
use App\ManualBank;
use App\ManualPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ManualPaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function getMethod()
    {
        $data['general'] = GeneralSetting::first();
        $data['basic'] = BasicSetting::first();
        $data['site_title'] = $data['general']->title;
        $data['page_title'] = "Manage Bank";
        $data['bank'] = ManualBank::all();
        return view('bank.manage-bank',$data);
    }
    public function storeMethod(Request $request)
    {

        $rules = array(
            'name' => 'required|unique:manual_banks,name',
            'acc_name' => 'required',
            'acc_number' => 'required',
            'acc_code' => 'required',
            'fix' => 'required',
            'percent' => 'required',
            'minimum' => 'required',
            'maximum' => 'required',
        );
        $validator = Validator::make ( Input::all (), $rules );
        if ($validator->fails()){
            return redirect()->back();
        }else{
            $category = ManualBank::create($request->all());
            return Response::json($category);
        }
    }
    public function editMethod($task_id)
    {
        $category = ManualBank::find($task_id);
        return Response::json($category);
    }
    public function updateMethod(Request $request,$task_id)
    {


        $cat = ManualBank::find($task_id);
        $rules = array(
            'name' => 'required|unique:manual_banks,name,'.$cat->id,
            'acc_name' => 'required',
            'acc_number' => 'required',
            'acc_code' => 'required',
            'fix' => 'required',
            'percent' => 'required',
            'minimum' => 'required',
            'maximum' => 'required',
        );
        $validator = Validator::make ( Input::all (), $rules );
        if ($validator->fails()){
            return redirect()->back();
        }else{
            $cat->name = $request->name;
            $cat->acc_name = $request->acc_name;
            $cat->acc_number = $request->acc_number;
            $cat->acc_code = $request->acc_code;
            $cat->minimum = $request->minimum;
            $cat->maximum = $request->maximum;
            $cat->save();
            return Response::json($cat);
        }
    }
    public function manualActive(Request $request)
    {
        
        $this->validate($request,[
           'id' => 'required',
        ]);
        $pp = ManualBank::findOrFail($request->id);
        $pp->status = 1;
        $pp->save();
        session()->flash('message', 'Payment Method Activate Successfully.');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');
        return redirect()->back();
    }
    public function manualDeActive(Request $request)
    {
        
        $this->validate($request,[
            'id' => 'required',
        ]);
        $pp = ManualBank::findOrFail($request->id);
        $pp->status = 0;
        $pp->save();
        session()->flash('message', 'Payment Method DeActivate Successfully.');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');
        return redirect()->back();
    }
}
