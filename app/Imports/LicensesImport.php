<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class LicensesImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $batchData = [];

        foreach ($rows as $row) {
            $batchData[] = [
                'name'         => $row['name'] ?? null,
                'license_type' => $row['license_type'] ?? null,
                'vehicle_type' => $row['vehicle_type'] ?? null,
                'cnic'         => $row['cnic'] ?? null,
                'extra'        => $row['extra'] ?? null,
                'license_no'   => $row['license_no'] ?? null,
                'status'       => $row['status'] ?? null,
                'issue_date'   => $this->parseDate($row['issue_date'] ?? null),
                'expiry_date'  => $this->parseDate($row['expiry_date'] ?? null),
                'address'      => $row['address'] ?? null,
                'office'       => $row['office'] ?? null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];

            if (count($batchData) >= 1000) {
                DB::table('licenses')->insert($batchData);
                $batchData = [];
            }
        }

        if (!empty($batchData)) {
            DB::table('licenses')->insert($batchData);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        if (is_numeric($date)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        try {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
