<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\RestaurantResource;



use App\Restaurant;
use App\Category;

class CategorySearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $allRestaurant = Restaurant::all();
        // $trueRestaurant = [];
        // foreach ($allRestaurant as $restaurant) {
        //     if ($restaurant->category[0]['id'] == $id) {
        //         $trueRestaurant[] = $restaurant;
        //     }
        // }
        // return response()->json($trueRestaurant);
        $category = Category::where('id', 'like', $id)->get()[0]['name'];
        $restaurant = Restaurant::whereHas('category', function (Builder $query) use ($category) {
            $query->where('name', 'like', $category);
        })->get();;
        return RestaurantResource::collection($restaurant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
