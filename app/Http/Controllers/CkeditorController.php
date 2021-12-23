<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CkeditorController extends Controller
{

    /**
     * success response method.
     *
     */
    public function upload(Request $request)
    {
        $originName = $request->file('upload')->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $request->file('upload')->getClientOriginalExtension();
        $fileName = $fileName . '_' . time() . '.' . $extension;
        $request->file('upload')->move(public_path('images/cke'), $fileName);

        return response()->json([
            'url' => asset('images/cke/' . $fileName)
        ]);
    }
}
