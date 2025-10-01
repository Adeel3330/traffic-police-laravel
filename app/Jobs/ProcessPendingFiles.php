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
    public $timeout = 600;
    public $tries = 3;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function handle(): void
    {
        $pendingPath = 'pendingFiles/' . $this->fileName;
        $fullPath = Storage::disk('public')->path($pendingPath);

        Log::info("Starting file processing", [
            'file' => $this->fileName,
            'full_path' => $fullPath,
            'file_exists' => Storage::disk('public')->exists($pendingPath)
        ]);

        if (!Storage::disk('public')->exists($pendingPath)) {
            Log::error("File not found: " . $pendingPath);
            return;
        }

        try {
            // Test if file is readable
            $fileSize = Storage::disk('public')->size($pendingPath);
            Log::info("File details", [
                'size_bytes' => $fileSize,
                'extension' => pathinfo($this->fileName, PATHINFO_EXTENSION)
            ]);

            // Import into DB
            Log::info("Starting actual import...");
            Excel::import(new LicensesImport, $fullPath);
            Log::info("Import completed successfully");

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
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }   

    public function failed(\Exception $exception)
    {
        Log::error("Job failed for file: " . $this->fileName, [
            'error' => $exception->getMessage()
        ]);
    }
}
