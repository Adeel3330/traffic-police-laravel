<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessPendingFiles;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function index()
    {
        return view('storage');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048',
        ]);

        // Get original filename
        $originalName = $request->file('file')->getClientOriginalName();

        // Get upload count → increment for next file
        $counterFile = 'file_counter.txt';
        $counter = 1;

        if (Storage::disk('local')->exists($counterFile)) {
            $counter = (int) Storage::disk('local')->get($counterFile);
            $counter++;
        }

        // Save new counter value
        Storage::disk('local')->put($counterFile, $counter);

        // Final filename → e.g., 1-myfile.csv
        $newFileName = $counter . '-' . $originalName;

        // Store file with prefixed number
        $path = $request->file('file')->storeAs('pendingFiles', $newFileName, 'public');

        // Dispatch background job
        ProcessPendingFiles::dispatch();

        return back()->with('success', "File '$newFileName' uploaded successfully! It will be processed soon.");
    }
}