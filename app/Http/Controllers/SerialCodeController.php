<?php

namespace App\Http\Controllers;

use App\Http\Requests\SerialCodeRequest;
use App\Models\SerialCode;
use Illuminate\Support\Facades\Redirect;

class SerialCodeController extends Controller
{
    public function verify(SerialCodeRequest $request)
    {
        $exists = SerialCode::where('code', $request->serial_code)->exists();

        $message = match($exists) {
            true => [
                'successMessage' => 'Document verified successfully.'
            ],
            false => [
                'errorMessage' => 'Serial code is invalid.'
            ]
        };

        return Redirect::route('dashboard')->with($message);
    }
}
