<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class CheckEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var Validator $validator */
        $validator = \Validator::make($request->all(), [
            'email' => 'required|unique:users,email'
        ]);
        return response()->json(['valid' => $validator->passes()]);
    }
}
