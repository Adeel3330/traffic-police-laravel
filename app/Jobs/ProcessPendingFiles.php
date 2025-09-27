<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LicensesImport;

class ProcessPendingFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fileName;
    public $timeout = 600; // 10 min
    public $tries = 3;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function handle(): void
    {
        $pendingPath = 'pendingFiles/' . $this->fileName;
        $fullPath = Storage::disk('public')->path($pendingPath);

        if (!Storage::disk('public')->exists($pendingPath)) {
            Log::warning("File not found: " . $this->fileName);
            return;
        }

        try {
            Log::info("Processing file: " . $this->fileName);

            // Import with chunk reading
            Excel::import(new LicensesImport, $fullPath);

            // Move file after success
            $uploadedPath = 'uploadedFiles/' . $this->fileName;
            Storage::disk('public')->move($pendingPath, $uploadedPath);

            Log::info("File moved to uploadedFiles", [
                'original' => $pendingPath,
                'new' => $uploadedPath,
            ]);
        } catch (\Exception $e) {
            Log::error("Error processing file: " . $this->fileName, [
                'message' => $e->getMessage(),
            ]);
            throw $e; // rethrow so job fails properly
        }
    }
}
