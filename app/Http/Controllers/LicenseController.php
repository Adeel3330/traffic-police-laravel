<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LicenseStatus;

class LicenseController extends Controller
{
    // Show form initially
    public function index()
    {
        $license = null; // always define $license
        return view('license.verify', compact('license'));
    }

    // Handle form submission
    public function verify(Request $request)
    {
        $request->validate([
            'user_license_number' => 'required|string'
        ]);

        $license = LicenseStatus::where('CNIC', $request->user_license_number)
                    ->orderBy('id', 'desc')
                    ->first();

        // even if $license is null, we pass it to view
        return view('license.verify', compact('license'));
    }
}
