<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LicensesImport;

class ProcessPendingFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        try {
            // Get files from public disk's pendingFiles directory
            $pendingFiles = Storage::disk('public')->files('pendingFiles');
            
            Log::info('ProcessPendingFiles: Found pending files', ['files' => $pendingFiles]);

            if (empty($pendingFiles)) {
                Log::info('ProcessPendingFiles: No files to process');
                return;
            }

            foreach ($pendingFiles as $fileName) {
                Log::info('ProcessPendingFiles: Processing file', ['file' => $fileName]);
                
                $fullPath = Storage::disk('public')->path($fileName);

                // Use Excel package to import data
                Excel::import(new LicensesImport, $fullPath);

                // Move file to uploadedFiles directory
                $newFileName = str_replace('pendingFiles/', 'uploadedFiles/', $fileName);
                Storage::disk('public')->move($fileName, $newFileName);

                Log::info('ProcessPendingFiles: File moved to uploadedFiles', [
                    'original' => $fileName,
                    'new_path' => $newFileName
                ]);
            }
        } catch (\Exception $e) {
            Log::error('ProcessPendingFiles: Error occurred', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            
            // Re-throw to mark job as failed
            throw $e;
        }
    }
}