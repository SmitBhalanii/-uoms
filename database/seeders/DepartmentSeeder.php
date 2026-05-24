<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'department_name' => 'Computer Lab',
                'lab_code' => 'COMP-LAB-001',
                'hod_name' => 'Dr. John Smith',
                'description' => 'Computer Science and IT Laboratory',
                'status' => true,
            ],
            [
                'department_name' => 'Electrical Lab',
                'lab_code' => 'ELEC-LAB-001',
                'hod_name' => 'Dr. Sarah Johnson',
                'description' => 'Electrical Engineering Laboratory',
                'status' => true,
            ],
            [
                'department_name' => 'Chemistry Lab',
                'lab_code' => 'CHEM-LAB-001',
                'hod_name' => 'Dr. Michael Brown',
                'description' => 'Chemistry and Chemical Engineering Laboratory',
                'status' => true,
            ],
            [
                'department_name' => 'Physics Lab',
                'lab_code' => 'PHYS-LAB-001',
                'hod_name' => 'Dr. Emily Davis',
                'description' => 'Physics and Applied Physics Laboratory',
                'status' => true,
            ],
            [
                'department_name' => 'Mechanical Lab',
                'lab_code' => 'MECH-LAB-001',
                'hod_name' => 'Dr. Robert Wilson',
                'description' => 'Mechanical Engineering Laboratory',
                'status' => true,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
