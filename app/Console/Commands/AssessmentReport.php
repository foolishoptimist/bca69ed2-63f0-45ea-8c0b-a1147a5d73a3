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
     * The console command input prompts.
     *
     * @var string
     */
    protected $studentIDPrompt = "Student ID:";
    protected $reportIDPrompt = "Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback):";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Please enter the following");

        $studentID = $this->argument('student_id');
        if ($studentID == -1) {
            $studentID = $this->ask($this->studentIDPrompt);
        }
        $reportID = $this->argument('report_id');
        if ($reportID == -1) {
            $reportID = $this->ask($this->reportIDPrompt);
        }

        //GenerateReport($studentID, $reportID)
    }
}
