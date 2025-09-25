<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LicenseStatus;

class LicenseController extends Controller
{
    public function index()
    {
        return view('license.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'user_license_number' => 'required|string'
        ]);

        $license = LicenseStatus::where('CNIC', $request->user_license_number)
                    ->orderBy('id', 'desc')
                    ->first();

        return view('license.verify', compact('license'));
    }
}
