<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shopping;
use Illuminate\Support\Facades\Validator;

class ShoppingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    // create shopping

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $shopping = Shopping::create($data);
        return response()->json([
            'data' => $shopping
        ]);
    }

    //get all shopping
    public function index()
    {
        $shopping = Shopping::all();
        return response()->json([
            'status' => 'success',
            'shopping' => $shopping
        ]);
    }

    //get shopping by id
    public function show($slug)
    {
        $shopping = Shopping::where('id', $slug)->first();

        if ($shopping) {

            return response()->json([
                'success' => true,
                'message'   => 'Detail Data SHopping',
                'product' => $shopping
            ], 200);
        } else {

            return response()->json([
                'success' => false,
                'message'   => 'Data Shopping Tidak Ditemukan',
            ], 404);
        }
    }

    // update shopping
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $shopping = Shopping::where('id', $id)->first();

        // if ($shopping) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Shopping Not Found'
        //     ], 404);
        // }

        $shopping->fill($data);

        $shopping->save();
        return response()->json([
            'status' => 'success',
            'data' => $shopping
        ]);
    }

    //delete shopping
    public function delete($id)
    {
        $shopping = new Shopping();

        if (Shopping::where('id', $id)->exists()) {
            $shopping = Shopping::find($id);
            $shopping->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Shopping not found"
            ], 404);
        }
    }
}
