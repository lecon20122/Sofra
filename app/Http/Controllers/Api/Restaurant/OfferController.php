<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addOffer(Request $request)
    {
        try {
            DB::beginTransaction();
            $record = $request->user()->offers()->create($request->all());
            if ($request->hasFile('image')) {
                $record->image = addImage($request); // addimage is in Helper
                $record->save();
            }
            DB::commit();
            return jsonResponse('1', 'Offer added successfuly', $record);
        } catch (\Throwable $th) {
            DB::rollBack();
            return jsonResponse('0', 'Process Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editOffer(Request $request)
    {
        // try {
        DB::beginTransaction();
        $record = $request->user()->offers()->find($request->id)
            ->update($request->all());
        if ($request->hasFile('image')) {
                deleteImage($record->image);
                $record->delete($record->image);
                $record->image = addImage($request);
                $record->save();
            }
        DB::commit();
        return jsonResponse('1', 'Offer added successfuly', $record);
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return jsonResponse('0', 'Process Failed');
        // }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
