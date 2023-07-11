<?php

namespace Database\Seeders;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CloneFiles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = File::query()->first();
        for ($i = 0; $i < 150; $i++) {
            $newFile = $file->replicate();
            $newFile->created_at = Carbon::now();
            $newFile->save();
        }
    }
}
