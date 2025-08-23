<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DistributionController;

class RekapDistribusiCommand extends Command
{
    protected $signature = 'rekap:distribusi';
    protected $description = 'Buat rekap distribusi seragam';

    public function handle()
    {
        app(DistributionController::class)->rekapDistribusi();
        $this->info('Rekap distribusi dijalankan: ' . now());
    }
}

