<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessPendingFiles;
use Illuminate\Support\Facades\Log;
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
            'file' => 'required|mimes:csv,xls,xlsx|max:20480', // 20 MB
        ]);

        // Get original filename
        $originalName = $request->file('file')->getClientOriginalName();

        // Maintain counter for unique file prefix
        $counterFile = 'file_counter.txt';
        $counter = 1;

        if (Storage::disk('local')->exists($counterFile)) {
            $counter = (int) Storage::disk('local')->get($counterFile);
            $counter++;
        }
        Storage::disk('local')->put($counterFile, $counter);

        // Final filename e.g. "5-myfile.csv"
        $newFileName = $counter . '-' . $originalName;

        // Save in "pendingFiles"
        $pendingPath = $request->file('file')->storeAs('pendingFiles', $newFileName, 'public');

        Log::info("File uploaded and saved for processing", [
            'file' => $newFileName,
            'path' => $pendingPath
        ]);

        // Dispatch job to process this file later
        ProcessPendingFiles::dispatch($newFileName);

        return back()->with('success', "File '$newFileName' uploaded successfully! Processing will happen in background.");
    }
}
