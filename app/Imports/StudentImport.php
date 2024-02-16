<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null
     */
    public function model(array $row)
    {
        // Create a new Student instance with data from the Excel row
        return new Student([
            'id'=>$row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'city' => $row['city'], // Assuming 'city' is the column name in your Excel file
            // 'password' => Hash::make($row['password']), // Assuming you're hashing the password
            // Add more fields as needed
        ]);
    }
}
