<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SellerCollection;
use App\Http\Resources\SellerResource;
use App\Models\Seller;
use Illuminate\Support\Facades\Validator;
use App\Rules\SellerDbLimit;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     *     path="/sellers",
     *     operationId="index",
     *     tags={"Sellers"},
     *     summary="Get list of sellers",
     *     description="Returns list of sellers",
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
        $sellers = Seller::all();
        return new SellerCollection($sellers);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/sellers/{id}",
     *     operationId="show",
     *     tags={"Sellers"},
     *     summary="Get seller by id",
     *     description="Returns specified seller",
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
     *                             "nome": "Test",
     *                             "email": "this_is_just_a_test",
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
        $seller = Seller::findOrFail($id);
        return new SellerResource($seller);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
	 *     path="/sellers/create",
	 *     operationId="store",
	 *     tags={"Sellers"},
	 *     summary="Create new seller",
	 *     description="Create new seller",
     *     @OA\Parameter(
     *         name="name",
     *         description="Name of the seller",
     *         required=true,
     *         example="Steve Jobs",
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         description="Email address of the seller",
     *         required=true,
     *         example="user@user.com",
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
     *                             "nome": "Test",
     *                             "email": "this_is_just_a_test",
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
            'name' => ['required', 'max:100', new SellerDbLimit],
            'email' => 'required|max:100|email|unique:sellers',
            
        ]);
        
        $seller = Seller::create($data);

        return response(['data' => new SellerResource($seller), 'message' => 'Created successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
	 *     path="/sellers/{id}",
	 *     operationId="update",
	 *     tags={"Sellers"},
	 *     summary="Update seller by id",
	 *     description="Update specified seller",
     *     @OA\Parameter(
     *         name="id",
     *         description="Id of the seller",
     *         required=true,
     *         example="1",
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         description="Name of the seller",
     *         required=false,
     *         example="Bill Gates",
     *         in="query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         description="Email address of the seller",
     *         required=false,
     *         example="user@user.com",
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
     *                             "nome": "Test",
     *                             "email": "this_is_just_a_test",
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
        $seller = Seller::findOrFail($id);
        $seller->update($request->all());
        return response(['data' => new SellerResource($seller), 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
	 *     path="/sellers/{id}",
	 *     operationId="delete",
	 *     tags={"Sellers"},
	 *     summary="Delete seller by id",
	 *     description="Delete specified seller",
     *     @OA\Parameter(
     *         name="id",
     *         description="Id of the seller",
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
        $seller = Seller::findOrFail($id)->whereDoesntHave('sales');
        $seller->delete();
        return response(['message' => 'Deleted successfully']);
    }
}