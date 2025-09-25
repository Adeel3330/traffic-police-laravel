<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LicensesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $batchData = [];
        
        // Detect if first row is a header
        $isFirstRowHeader = $this->isHeaderRow($rows);
        
        Log::info('First row detected as header: ' . ($isFirstRowHeader ? 'YES' : 'NO'));
        
        foreach ($rows as $index => $row) {
            // Skip empty rows
            if (empty($row[0]) || (is_string($row[0]) && trim($row[0]) === '')) {
                Log::info('Skipping empty row: ' . $index);
                continue;
            }
            
            // Skip the first row if it's a header
            if ($index === 0 && $isFirstRowHeader) {
                Log::info('Skipping header row: ' . json_encode($row->toArray()));
                continue;
            }
            
            // Log the row being processed
            Log::info('Processing row ' . $index . ': ' . json_encode($row->toArray()));
            
            $batchData[] = [
                'name'         => $row[0] ?? null,
                'license_type' => $row[1] ?? null,
                'vehicle_type' => $row[2] ?? null,
                'cnic'         => $row[3] ?? null,
                'extra'        => $row[4] ?? null,
                'license_no'   => $row[5] ?? null,
                'status'       => $row[6] ?? null,
                'issue_date'   => $this->parseDate($row[7] ?? null),
                'expiry_date'  => $this->parseDate($row[8] ?? null),
                'address'      => $row[9] ?? null,
                'office'       => $row[10] ?? null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];

            // Insert batch of 1000 rows
            if (count($batchData) >= 1000) {
                DB::table('licenses')->insert($batchData);
                Log::info('Inserted batch of 1000 rows');
                $batchData = [];
            }
        }

        // Insert remaining rows
        if (!empty($batchData)) {
            DB::table('licenses')->insert($batchData);
            Log::info('Inserted remaining ' . count($batchData) . ' rows');
        }
        
        Log::info('Import completed successfully. Total rows processed: ' . ($rows->count() - ($isFirstRowHeader ? 1 : 0)));
    }

    /**
     * Improved header detection specifically for your use case
     */
    private function isHeaderRow(Collection $rows)
{
    if ($rows->isEmpty()) {
        return false;
    }

    $firstRow = $rows->first()->toArray();

    // If first cell is literally "name" (case-insensitive) → it's a header
    if (isset($firstRow[0]) && strtolower(trim($firstRow[0])) === 'name') {
        return true;
    }

    // Otherwise, always treat as data
    return false;
}

    
    /**
     * Check if a value looks like a person name (based on your examples)
     */
    private function isPersonName($value)
    {
        if (empty($value) || !is_string($value)) {
            return false;
        }
        
        // Person names in your examples start with titles like "Mr.", "Ms.", etc.
        $namePatterns = [
            '/^(Mr\.|Ms\.|Mrs\.|Dr\.|Prof\.)/i', // Starts with title
            '/[A-Z][a-z]+ [A-Z][a-z]+/', // Has at least two capitalized words
        ];
        
        foreach ($namePatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Check if a value looks like a license type (based on your examples)
     */
    private function isLicenseType($value)
    {
        if (empty($value) || !is_string($value)) {
            return false;
        }
        
        $licenseTypes = [
            'license renewal', 'new driving license', 'license upgradation',
            'permanent', 'commercial', 'learner',
            'htv-incl-psv', 'm cycle/car', 'ltv-excl-psv', 'htv-excl-psv'
        ];
        
        $valueLower = strtolower($value);
        
        foreach ($licenseTypes as $type) {
            if (strpos($valueLower, $type) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Check if a value looks like a CNIC number (based on your examples)
     */
    private function isCnic($value)
    {
        if (empty($value)) {
            return false;
        }
        
        // CNIC pattern: XXXXX-XXXXXXX-X
        return preg_match('/^\d{5}-\d{7}-\d{1}$/', $value) || 
               preg_match('/^\d{5}-\d{7}-\d{1}[a-zA-Z]?$/', $value);
    }
    
    /**
     * Check if a value looks like a license number (based on your examples)
     */
    private function isLicenseNumber($value)
    {
        if (empty($value)) {
            return false;
        }
        
        // License number patterns from your examples
        return preg_match('/^RKT-/', $value) || 
               preg_match('/^LIC-/', $value) ||
               preg_match('/[A-Z]{3}-\d+/', $value);
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        // Try to parse Excel date serial number
        if (is_numeric($date)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            } catch (\Exception $e) {
                Log::warning('Failed to parse Excel date: ' . $date);
            }
        }

        // Try to parse various date formats
        try {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning('Failed to parse date: ' . $date);
            return null;
        }
    }
}