<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Generate Image upload View
     *
     * @return void
     */
    public function dropzone() {
        return view('dropzone');
    }
    /**
     * Image Upload Code
     *
     * @return void
     */
    public function dropzoneStore(Request $request) {
        $image = $request->file('file');
        $imageName = time().$image->getClientOriginalName();
        $image->move(public_path('images'),$imageName);
        return response()->json(['success'=>$imageName]);
    }
}
