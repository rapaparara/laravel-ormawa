<?php

namespace App\Livewire;

use Livewire\Component;

class Laporan extends Component
{
    public function render()
    {
        $data = [
            'labels' => ['January', 'February', 'March', 'April', 'May'],
            'data' => [65, 59, 80, 81, 56],
        ];
        return view('livewire.laporan',['dataCharts' => $data]);
    }
}
