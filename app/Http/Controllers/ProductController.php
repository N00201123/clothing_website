<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreProductRequest;

use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
    * @OA\Get(
    *     path="/api/product",
    *     description="Displays all the products",
    *     tags={"Product"},
     *      @OA\Response(
        *          response=200,
        *          description="Successful operation, Returns a list of Products in JSON format"
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
        return new ProductCollection(Product::all());
        // ->with('categories')
        // ->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/product",
     *      operationId="storeAgain",
     *      tags={"Product"},
     *      summary="Create a new Product",
     *      description="Stores the product in the DB",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title", "description", "date", "price", "size", "type", "image"},
     *            @OA\Property(property="title", type="string", format="sting", example="T-Shirt"),
     *            @OA\Property(property="description", type="string", format="string", example="This is a T-Shirt"),
     *            @OA\Property(property="date", type="date", format="date", example="2023-01-01"),
     *            @OA\Property(property="price", type="float", format="float", example="49.49"),
     *            @OA\Property(property="size", type="string", format="string", example="L"),
     *            @OA\Property(property="type", type="string", format="string", example="men"),
     *             @OA\Property(property="image", type="string", format="string", example="T-Shirt")
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
     * @param  \Illuminate\Http\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //$product = Product::create($request->only([
        //     'title', 'description', 'date', 'price', 'size', 'type', 'image'
        //]));

        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $filename = date('Y-m-d-His') . '_' . $request->input('title') . '.'. $extension;

        // store the file $book_image in /public/images, and name it $filename

        // $path = $image->storeAs('images', $filename, 's3');
        $filename = Storage::put('products', $image);



        $product = Product::create([
            'title' => $request->title, 
            'description' => $request->description, 
            'date' => $request->date,
            'price' => $request->price,
            'size' => $request->size,
            'type' => $request->type,
            //'image' => $request->image,
            'image' => $filename
         ]);

        $product->categorys()->attach($request->categorys);
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
    *     path="/api/product/{id}",
    *     description="Gets a product by ID",
    *     tags={"Product"},
    *          @OA\Parameter(
        *          name="id",
        *          description="Product id",
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/api/product/{id}",
     *      operationId="update",
     *      tags={"Product"},
     *      summary="Update a Product",
     *      description="Updates the product in the DB",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(name="id", in="path", description="Id of a Product", required=true,
     *      @OA\Schema(type="integer")
     *    ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title", "description", "date", "price", "size", "type", "image"},
     *            @OA\Property(property="title", type="string", format="string", example="Sample Title"),
     *            @OA\Property(property="description", type="string", format="string", example="A long description about this great produt"),
     *            @OA\Property(property="date", type="date", format="date", example="2023-01-01"),
     *            @OA\Property(property="price", type="float", format="float", example="9.99"),
     *            @OA\Property(property="size", type="string", format="string", example="L"),
     *            @OA\Property(property="type", type="string", format="string", example="men"),
     *            @OA\Property(property="image", type="string", format="string", example="hi")
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();

        $filename = date('Y-m-d-His') . '_' . $request->input('title') . '_' . $extension;

        //$path = $image->storeAs('public/images', $filename);

        $filename = Storage::put('products', $image);

        $product ->update($request->only([
            'title', 'description', 'date', 'price', 'size', 'type'
        ]));

        $product->update([
            'image' => $filename]
        );
        
        return new ProductResource($product);
    }

    /**
     *
     *
     * @OA\Delete(
     *    path="/api/product/{id}",
     *    operationId="destroy",
     *    tags={"Product"},
     *    summary="Delete a Product",
     *    description="Delete Product",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id of a Product", required=true,
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
