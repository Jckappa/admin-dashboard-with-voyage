<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use League\Csv\Reader;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $csvPath = storage_path('app/onlinefoods.csv');

        if (!file_exists($csvPath)) {
            throw new \Exception("CSV file not found: " . $csvPath);
        }

        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Customer::create([
                'age' => $record['Age'],
                'gender' => $record['Gender'],
                'marital_status' => $record['Marital_Status'],
                'occupation' => $record['Occupation'],
                'monthly_income' => $record['Monthly_Income'],
                'educational_qualifications' => $record['Educational_Qualifications'],
                'family_size' => $record['Family_size'],
                'latitude' => $record['latitude'],
                'longitude' => $record['longitude'],
                'pin_code' => $record['Pin_code'],
                'order_status' => $record['Output'],
                'feedback' => $record['Feedback']
            ]);
        }
    }
}

