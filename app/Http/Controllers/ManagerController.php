<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ManagerCollection;
use App\Http\Resources\ManagerResource;
use App\Models\Manager;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     *     path="/managers",
     *     operationId="index",
     *     tags={"Managers"},
     *     summary="Get list of managers",
     *     description="Returns list of managers",
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
     *                             {
     *                                 "codigo": 1,
     *                                 "email": "this_is_just_a_test",
     *                                 "data_criacao": "2021-09-14T13:31:52.000000Z"
     *                             },
     *                             {
     *                                 "codigo": 2,
     *                                 "email": "this_is_just_a_test2",
     *                                 "data_criacao": "2021-09-14T13:32:52.000000Z"
     *                             }
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
    public function index()
    {
        $managers = Manager::all();
        return new ManagerCollection($managers);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/managers/{id}",
     *     operationId="show",
     *     tags={"Managers"},
     *     summary="Get manager by id",
     *     description="Returns specified manager",
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
     *         },
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
        $manager = Manager::findOrFail($id);
        return new ManagerResource($manager);
    }
}