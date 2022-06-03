<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvContents = file_get_contents(storage_path('app/students.csv'));

        $records = explode(PHP_EOL, $csvContents);
        $headers = array_shift($records);
        array_pop($records);

        foreach ($records as $record) {
            $record = explode(",", $record);

            Student::create([
                'id' => $record[0],
                'first_name' => $record[1],
                'last_name' => $record[2],
                'email' => $record[3],
            ]);
        }
    }
}
