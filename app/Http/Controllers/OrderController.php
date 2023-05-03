<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
     /**
     * Display a listing of the resource.
     * 
    * @OA\Get(
    *     path="/api/order",
    *     description="Displays all the orders",
    *     tags={"Order"},
     *      @OA\Response(
        *          response=200,
        *          description="Successful operation, Returns a list of Orders in JSON format"
        *       ),
        *      @OA\Response(
        *          response=401,
        *          description="Unauthenticated",
        *      ),
        *      @OA\Response(
        *          response=403,
        *          description="Forbidden"
        *      )
 * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return new OrderCollection(Order::all());
        return new OrderCollection(Order::with('customer')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/order",
     *      operationId="store",
     *      tags={"Order"},
     *      summary="Create a new Order",
     *      description="Stores the order in the DB",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"date", "shipping_price, customer_id"},
     *            @OA\Property(property="date", type="date", format="date", example="2023-01-01"),
     *            @OA\Property(property="shipping_price", type="float", format="float", example="0.99"),
     *            @OA\Property(property="customer_id", type="integer", format="integer", example="2")
     *          )
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\OrderResource
     */
    public function store(Request $request)
    {
        // $order = Order::create($request->only([
        //     'date', 'shipping_price', 'customer_id'
        // ]));

        
        $order = Order::create([
            'date' => $request->date,
            'shipping_price' => $request->shipping_price,
            'customer_id' => $request->customer_id
        ]);

        //$order->products()->attach($request->products);
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
    *     path="/api/order/{id}",
    *     description="Gets an order by ID",
    *     tags={"Order"},
    *          @OA\Parameter(
        *          name="id",
        *          description="Order id",
        *          required=true,
        *          in="path",
        *          @OA\Schema(
        *              type="integer")
     *          ),
        *      @OA\Response(
        *          response=200,
        *          description="Successful operation"
        *       ),
        *      @OA\Response(
        *          response=401,
        *          description="Unauthenticated",
        *      ),
        *      @OA\Response(
        *          response=403,
        *          description="Forbidden"
        *      )
 * )
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->only([
            'date', 'shipping_price', 'customer_id'
        ]));

        return new OrderResource($order);
    }

    /**
     *
     *
     * @OA\Delete(
     *    path="/api/order/{id}",
     *    operationId="destroyOrder",
     *    tags={"Order"},
     *    summary="Delete an Order",
     *    description="Delete Order",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id of an Order", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *         response=Response::HTTP_NO_CONTENT,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status_code", type="integer", example="204"),
     *         @OA\Property(property="data",type="object")
     *          ),
     *       )
     *      )
     *  )
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
