<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderMonth($id)
    {
        $allOrder = Order::whereHas('dish', function($q) use($id) {
            $q->where('dishes.restaurant_id', $id);
        })->select(
            DB::raw('sum(total_price) as `sums`'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months"),
            DB::raw('max(created_at) as createdAt')
     )
           ->where("created_at", ">", \Carbon\Carbon::now()->subMonths(6))
           ->orderBy('createdAt', 'asc')
           ->groupBy('months')
           ->get();;
    //    >where('type','post')
    //   ->where('active',1)
    //   ->orderBy('post_date','desc')
    //   ->paginate(5);
        // $allOrder = Db::table('orders')->select(
        //     DB::raw('sum(total_price) as sums'),
        //     DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        // )
        //     ->where("created_at", ">")
        //     ->groupBy('months')
        //     ->get();
        // $trueOrder = [];
        // foreach ($allOrder as $order) {
        //     if ($order->dish[0]->restaurant['id'] == $id) {
        //         $trueOrder[] = $order;
        //     }
        // }
        // return OrderResource::collection($trueOrder);
        // $order = Order::select(
        //     DB::raw('sum(total_price) as sums'),
        //     DB::raw("DATE_FORMAT(created_at,'%M %Y') as months")
        // )
        //     ->where("created_at", ">")
        //     ->groupBy('months')
        //     ->get();
        return response($allOrder);
    }

    public function bestDish($id)
    {
        $allOrder = Order::join('dish_order', 'orders.id', '=', 'dish_order.order_id')
        ->join('dishes', 'dishes.id', '=', 'dish_order.dish_id' )->where('restaurant_id', $id)
        ->select(
            DB::raw('dishes.id as `dish`'),
            DB::raw('dishes.name as `name`'),
            DB::raw('count(quantity) as `countDish`'),
            DB::raw("DATE_FORMAT(orders.created_at,'%M %Y') as months"),
            DB::raw('max(orders.created_at) as createdAt')
     )
           ->groupBy('dish')
           ->where("orders.created_at", ">", \Carbon\Carbon::now()->subMonths(6))
           ->orderBy('createdAt', 'asc')
           ->groupBy('months')
           ->get();;
    return response($allOrder);
    }
    public function month() 
    {
        return response(\Carbon\Carbon::now()->format('M'));
    }

}