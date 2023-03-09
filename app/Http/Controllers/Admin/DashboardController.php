<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Statistical;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(){
        $users = User::get();
        $courseSold = Order::where('status', Order::STATUS['SUCCESS'])->get();
        $revenue = 0;
        if(count($courseSold)>0){
            foreach ($courseSold as $item){
                $revenue += $item->total;
            }
        }
        return view('dashboard')->with([
            'users' => $users,
            'courseSold'=>$courseSold,
            'revenue' => $revenue
        ]);
    }
    public function fillter(Request $request){
        $data = request()->all();
        $chart_data = [];
        if( $data['from_date'] && $data['to_date']){
            $from_date = $data['from_date'];
            $to_date = $data['to_date'];
        }else{
            $from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
            $to_date = Carbon::now()->format('Y-m-d');
        }
        $get = Statistical::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();
        foreach($get as $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order'=> $val->total_order,
                'price'=>$val->price,
            );
        }
        echo $data = json_encode($chart_data);
    }
}
