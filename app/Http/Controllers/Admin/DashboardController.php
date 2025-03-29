<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        // Get data from customers table
        $customers = Customer::all()->toArray();
        
        // Map database fields to match CSV column names for compatibility
        $data = [];
        foreach ($customers as $customer) {
            $data[] = [
                'Age' => $customer['age'],
                'Gender' => $customer['gender'],
                'Marital_Status' => $customer['marital_status'],
                'Occupation' => $customer['occupation'],
                'Monthly_Income' => $customer['monthly_income'],
                'Educational_Qualifications' => $customer['educational_qualifications'],
                'Family_size' => $customer['family_size'],
                'latitude' => $customer['latitude'],
                'longitude' => $customer['longitude'],
                'Pin_code' => $customer['pin_code'],
                'Output' => $customer['order_status'],
                'Feedback' => $customer['feedback']
            ];
        }
        
        // Prepare data for charts
        $ageGroups = $this->prepareAgeData($data);
        $genderDistribution = $this->prepareGenderData($data);
        $occupationDistribution = $this->prepareOccupationData($data);
        $incomeDistribution = $this->prepareIncomeData($data);
        $feedbackDistribution = $this->prepareFeedbackData($data);
        
        return view('admin.dashboard', compact(
            'ageGroups', 
            'genderDistribution', 
            'occupationDistribution', 
            'incomeDistribution',
            'feedbackDistribution'
        ));
    }
    
    private function prepareAgeData($data)
    {
        $ageGroups = [
            '18-20' => 0,
            '21-25' => 0,
            '26-30' => 0,
            '31+' => 0
        ];
        
        foreach ($data as $row) {
            $age = (int) $row['Age'];
            
            if ($age <= 20) {
                $ageGroups['18-20']++;
            } elseif ($age <= 25) {
                $ageGroups['21-25']++;
            } elseif ($age <= 30) {
                $ageGroups['26-30']++;
            } else {
                $ageGroups['31+']++;
            }
        }
        
        return [
            'labels' => array_keys($ageGroups),
            'data' => array_values($ageGroups)
        ];
    }
    
    private function prepareGenderData($data)
    {
        $genders = [];
        
        foreach ($data as $row) {
            $gender = $row['Gender'];
            if (!isset($genders[$gender])) {
                $genders[$gender] = 0;
            }
            $genders[$gender]++;
        }
        
        return [
            'labels' => array_keys($genders),
            'data' => array_values($genders)
        ];
    }
    
    private function prepareOccupationData($data)
    {
        $occupations = [];
        
        foreach ($data as $row) {
            $occupation = $row['Occupation'];
            if (!isset($occupations[$occupation])) {
                $occupations[$occupation] = 0;
            }
            $occupations[$occupation]++;
        }
        
        return [
            'labels' => array_keys($occupations),
            'data' => array_values($occupations)
        ];
    }
    
    private function prepareIncomeData($data)
    {
        $incomes = [];
        
        foreach ($data as $row) {
            $income = $row['Monthly_Income'];
            if (!isset($incomes[$income])) {
                $incomes[$income] = 0;
            }
            $incomes[$income]++;
        }
        
        return [
            'labels' => array_keys($incomes),
            'data' => array_values($incomes)
        ];
    }
    
    private function prepareFeedbackData($data)
    {
        $feedback = [
            'Positive' => 0,
            'Negative' => 0
        ];
        
        foreach ($data as $row) {
            if (isset($row['Feedback'])) {
                $feedbackValue = trim($row['Feedback']);
                if ($feedbackValue === 'Positive') {
                    $feedback['Positive']++;
                } elseif ($feedbackValue === 'Negative' || $feedbackValue === 'Negative ') {
                    $feedback['Negative']++;
                }
            }
        }
        
        return [
            'labels' => array_keys($feedback),
            'data' => array_values($feedback)
        ];
    }
}
