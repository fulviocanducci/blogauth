<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ValidationMake
{
    function valid(Request $request, array $rules)
    {
        return Validator::make($request->all(), $rules);
    }
}
