<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SaleCollection;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use Illuminate\Support\Facades\Validator;
use App\Rules\SaleDbLimit;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     *     path="/sales",
     *     operationId="index",
     *     tags={"Sales"},
     *     summary="Get list of sales",
     *     description="Returns list of sales",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     )
     * )
     */
    public function index()
    {
        $sales = Sale::all();
        return new SaleCollection($sales);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/sales/{id}",
     *     operationId="show",
     *     tags={"Sales"},
     *     summary="Get sale by id",
     *     description="Returns specified sale",
     *     @OA\Parameter(
     *         name="id",
     *         description="Id",
     *         required=true,
     *         example="1",
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "data": {
     *                             "codigo": 1,
     *                             "sale": "Test",
     *                             "preco": "315000.00",
     *                             "comissao": "10234.90",
     *                             "data_criacao": "2021-09-14T13:31:52.000000Z"
     *                         }
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="not found"
     *     )
     * )
     */
    public function show(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        return new SaleResource($sale);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
	 *     path="/sales/create",
	 *     operationId="store",
	 *     tags={"Sales"},
	 *     summary="Create new sale",
	 *     description="Create new sale",
     *     @OA\Parameter(
     *         name="seller_id",
     *         description="Id of the seller",
     *         required=true,
     *         example="1",
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="price",
     *         description="Price of the sale",
     *         required=true,
     *         example="1000.55",
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Created Successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "data": {
     *                             "codigo": 1,
     *                             "seller": "Test",
     *                             "preco": "456000.89",
     *                             "comissao": "71000.32",
     *                             "data_criacao": "2021-09-14T13:31:52.000000Z"
     *                         },
     *                         "message": "Created successfully"
     *                     }
     *                 )
     *             )
     *         }
     *     ),
	 *     @OA\Response(response=201, description="Created Successfully"),
	 *     @OA\Response(response=422, description="Unprocessable Entity"),
	 *     @OA\Response(response=400, description="Bad request"),
	 *     @OA\Response(response=404, description="Resource Not Found")
	 * )
	 */
    public function store(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'seller_id' => 'required|integer|exists:App\Models\Seller,id',
            'price' => ['required', 'numeric', new SaleDbLimit],
        ]);

        $sale = Sale::create($data);

        return response(['data' => new SaleResource($sale), 'message' => 'Created successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
	 *     path="/sales/{id}",
	 *     operationId="update",
	 *     tags={"Sales"},
	 *     summary="Update sale by id",
	 *     description="Update specified sale",
     *     @OA\Parameter(
     *         name="id",
     *         description="Id of the sale",
     *         required=true,
     *         example="1",
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="seller_id",
     *         description="Id of the seller",
     *         required=false,
     *         example="1",
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="price",
     *         description="Price of the sale",
     *         required=false,
     *         example="9988.77",
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated Successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "data": {
     *                             "codigo": 1,
     *                             "seller_id": 1,
     *                             "preco": 199100.28,
     *                             "data_criacao": "2021-09-14T13:31:52.000000Z"
     *                         },
     *                         "message": "Updated successfully"
     *                     }
     *                 )
     *             )
     *         }
     *     ),
	 *     @OA\Response(response=201, description="Updated Successfully"),
	 *     @OA\Response(response=422, description="Unprocessable Entity"),
	 *     @OA\Response(response=400, description="Bad request"),
	 *     @OA\Response(response=404, description="Resource Not Found")
	 * )
	 */
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->update($request->all());
        return response(['data' => new SaleResource($sale), 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
	 *     path="/sales/{id}",
	 *     operationId="delete",
	 *     tags={"Sales"},
	 *     summary="Delete sale by id",
	 *     description="Delete specified sale",
     *     @OA\Parameter(
     *         name="id",
     *         description="Id of the sale",
     *         required=true,
     *         example="1",
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deleted Successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "message": "Deleted successfully"
     *                     }
     *                 )
     *             )
     *         }
     *     ),
	 *     @OA\Response(response=201, description="Deleted Successfully"),
	 *     @OA\Response(response=422, description="Unprocessable Entity"),
	 *     @OA\Response(response=400, description="Bad request"),
	 *     @OA\Response(response=404, description="Resource Not Found")
	 * )
	 */
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return response(['message' => 'Deleted successfully']);
    }
}