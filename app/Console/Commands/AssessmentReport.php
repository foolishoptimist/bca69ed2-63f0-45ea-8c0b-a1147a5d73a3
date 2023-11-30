<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AssessmentReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assessment-report {student_id=-1} {report_id=-1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Student Assessment Report. Params: <student_id> <report_id>';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
