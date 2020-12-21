<?php

function jsonResponse($status , $msg , $data = null){
    $response = [
        'status' => $status ,
        'message' => $msg ,
        'data' => $data,
    ];
    return response()->json($response);
}

function addImage($request)
{
    if ($request->hasFile('image')) {
        if ($request->file('image')->isValid()) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().".".$ext;
            $file->move('uploads/images',$filename);
        }
    }

    return $filename;
}
