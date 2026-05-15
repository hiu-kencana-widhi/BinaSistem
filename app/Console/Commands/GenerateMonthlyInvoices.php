<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateMonthlyInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-monthly-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate SPP invoices for all active students for the current month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting invoice generation...');

        // Fetch all active students
        $students = \App\Models\User::role('murid')->where('is_active', true)->get();
        
        $month = date('m');
        $year = date('Y');
        $amount = 350000; // Fixed SPP amount for example

        $count = 0;
        foreach ($students as $student) {
            $invoice = \App\Models\Invoice::firstOrCreate([
                'student_id' => $student->id,
                'month' => $month,
                'year' => $year,
            ], [
                'amount' => $amount,
                'status' => 'unpaid'
            ]);

            if ($invoice->wasRecentlyCreated) {
                $count++;
            }
        }

        $this->info("Successfully generated {$count} new invoices for {$month}/{$year}.");
    }
}
