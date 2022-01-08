<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transaction::orderBy('time', 'desc')->get();
        $response  = [
            'data' => $data,
            'status' => 'success'
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'type' => 'required|in:expense,revenue'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $data = Transaction::create($request->all());
            return response()->json([
                'data' => $data,
                'status' => 'ok'
            ], Response::HTTP_CREATED);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'failed ' . $e
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $response = [
            'data' => $transaction,
            'status' => 'ok'
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'type' => 'required|in:expense,revenue'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $data = $transaction->update($request->all());
            $data = $transaction;
            return response()->json([
                'data' => $data,
                'status' => 'ok'
            ], Response::HTTP_OK);
        } catch (QueryException $e) {

            return response()->json([
                'message' => 'failed ' . $e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->delete();
            $response = [
                'status' => 'ok'
            ];
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'failed ' . $e
            ]);
        }


        return response()->json($response, Response::HTTP_OK);
    }
}
