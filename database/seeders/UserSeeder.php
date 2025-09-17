<?php

namespace Database\Seeders;

use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole('admin');

        // Student user
        $user = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password123'),
            ]
        );
        // إنشاء سجل الطالب المرتبط بالمستخدم
        $user->student()->updateOrCreate(
            [], // الشرط فارغ لأنه hasOne → واحد فقط
            [
                'major' => 'Computer Science',
                'points' => 0,
                'year' => 2,
                'bio' => 'طالب متفوق مهتم بالبرمجة',
            ]
        );
        // إضافة الدور
        $user->assignRole('student');


        // Supervisor user
        $supervisor = User::firstOrCreate(
            ['email' => 'supervisor@example.com'],
            [
                'name' => 'Supervisor User',
                'password' => Hash::make('password123'),
            ]
        );

        $supervisor->supervisor()->updateOrCreate(
            [],
            [
                'specialization_id' => 1,
                // 'department_id'     => 1,
            ]
        );
        $supervisor->assignRole('supervisor');
    }
}
