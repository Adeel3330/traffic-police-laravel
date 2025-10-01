<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class LicensesImport implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        Log::info("LicensesImport started processing", [
            'total_rows' => $rows->count()
        ]);

        $batchData = [];
        $rowCount = 0;

        foreach ($rows as $row) {
            $rowCount++;

            // Debug first 2 rows
            if ($rowCount <= 2) {
                Log::info("Row {$rowCount} raw data:", [
                    'data' => $row->toArray(),
                    'column_count' => $row->count()
                ]);
            }

            $batchData[] = [
                'ApplicantName'   => $row[0],
                'LicenseCategory' => $row[1],
                'LicenseType'     => $row[2],
                'CNIC'            => $row[3],
                'LearnerNumber'   => $row[4],
                'LicenseNumber'   => $row[5],
                'Status'          => $row[6],
                'issue_date'      => $row[7] ?? null,
                'expire_date'     => $row[8] ?? null,
                'address'         => $row[9],
                'district_name'   => $row[10],
                'updated_at'      => now(),
                'is_updated'      => 0,
                'is_added'        => 0,
            ];

            if (count($batchData) >= 100) {
                try {
                    DB::table('dlms_license_status')->insert($batchData);
                    Log::info("Inserted batch of " . count($batchData) . " records");
                    $batchData = [];
                } catch (\Exception $e) {
                    Log::error("Error inserting batch", [
                        'error' => $e->getMessage(),
                        'batch_size' => count($batchData)
                    ]);
                    throw $e;
                }
            }
        }

        // Insert remaining records
        if (!empty($batchData)) {
            try {
                DB::table('dlms_license_status')->insert($batchData);
                Log::info("Inserted final batch of " . count($batchData) . " records");
            } catch (\Exception $e) {
                Log::error("Error inserting final batch", [
                    'error' => $e->getMessage(),
                    'batch_size' => count($batchData)
                ]);
                throw $e;
            }
        }

        Log::info("LicensesImport completed", [
            'total_rows_processed' => $rowCount
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
