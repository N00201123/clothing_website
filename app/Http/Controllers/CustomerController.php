<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
    * @OA\Get(
    *     path="/api/customer",
    *     description="Displays all the customers",
    *     tags={"Customer"},
     *      @OA\Response(
        *          response=200,
        *          description="Successful operation, Returns a list of Customers in JSON format"
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
        return new CustomerCollection(Customer::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/customer",
     *      operationId="storeCustomer",
     *      tags={"Customer"},
     *      summary="Create a new Customer",
     *      description="Stores the customer in the DB",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"first_name", "last_name", "email", "phone", "address"},
     *            @OA\Property(property="first_name", type="string", format="string", example="Darren"),
     *            @OA\Property(property="last_name", type="string", format="string", example="Glen"),
     *            @OA\Property(property="email", type="=string", format="string", example="darrenglen@hotmail.com"),
     *            @OA\Property(property="phone", type="integer", format="integer", example="0865401236"),
     *             @OA\Property(property="address", type="string", format="string", example="1 Cleveland Street")
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
     * @param  \Illuminate\Http\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        //  $customer = Customer::create($request->only([
        //     'first_name', 'last_name', 'email', 'phone', 'address'
        //  ]));
        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

         return new CustomerResource($customer);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
    *     path="/api/customer/{id}",
    *     description="Gets a customer by ID",
    *     tags={"Customer"},
    *          @OA\Parameter(
        *          name="id",
        *          description="Customer id",
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/api/customer/{id}",
     *      operationId="updateCustomer",
     *      tags={"Customer"},
     *      summary="Update a Customer",
     *      description="Updates the customer in the DB",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="id", in="path", description="Id of a Customer", required=true,
     *      @OA\Schema(type="integer")
     *    ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"first_name", "last_name", "email", "phone", "address"},
     *            @OA\Property(property="first_name", type="string", format="string", example="John"),
     *            @OA\Property(property="last_name", type="string", format="string", example="Peterson"),
     *            @OA\Property(property="email", type="string", format="string", example="johnp@gmail.com"),
     *            @OA\Property(property="phone", type="integer", format="integer", example="0874132088"),
     *            @OA\Property(property="address", type="string", format="string", example="185 Parley Road")            
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer ->update($request->only([
            'first_name', 'last_name', 'email', 'phone', 'address'
        ]));
        
        return new CustomerResource($customer);
        //$customer->update($request->all());
    }

    /**
     *
     *
     * @OA\Delete(
     *    path="/api/customer/{id}",
     *    operationId="destroyCustomer",
     *    tags={"Customer"},
     *    summary="Delete a Customer",
     *    description="Delete Customer",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id of a Customer", required=true,
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
