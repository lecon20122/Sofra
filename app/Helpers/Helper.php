<?php
use Illuminate\Support\Facades\Storage;

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

function deleteImage($image)
{
    $filePath = 'uploads/images/'.$image;
    if (\File::exists(public_path($filePath))){
        \File::delete($filePath);
    }
}
// $record = Post::find($id);
//         File::delete('uploads/posts_images/'.$record->image);
//         $record->delete();

function settings($key)
{
    $settings = \App\Models\Setting::where('name' , $key)->first();

    if($settings){
        return $settings;
    }else{
        return new \App\Models\Setting;
    }
}

function notifyByFirebase($title , $body , $tokens , $data = [])
{
    $registerionIDs = $tokens;

    $fcmMsg = [
        'body' => $body ,
        'title' => $title ,
        'sound' => "default",
        'color' => "#203E78"
    ];
    $fcmField = [
        'registeration_ids' => $registerionIDs,
        'priority' => 'high' ,
        'notification' => $fcmMsg,
    ];
    $headers = [
        'Authorization: key=' . env('FIREBASE_API_ACCESS_KEY '),
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fcmField);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
