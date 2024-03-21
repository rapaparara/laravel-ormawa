<?php

namespace App\Imports;

use App\Models\pengurus;
use Maatwebsite\Excel\Concerns\ToModel;

class PengurusImport implements ToModel
{
    private $kepengurusan_id;
    public function __construct($kepengurusan_id)
    {
        $this->kepengurusan_id = $kepengurusan_id;
    }
    public function model(array $row)
    {
        return new pengurus([
            'nim' => $row[1],
            'nama' => $row[2],
            'kepengurusan_id' => $this->kepengurusan_id,
        ]);
    }
}
