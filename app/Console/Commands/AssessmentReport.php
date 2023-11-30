<?php

namespace App\Console\Commands;

use App\Models\Student;
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

    protected $reportTypes = [
        1 => 'Diagnostic',
        2 => 'Progress',
        3 => 'Feedback'
    ];

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
        while (!Student::findById($studentID)) {
            $this->error('Incorrect Student ID');
            $studentID = $this->ask($this->studentIDPrompt);
        }
        $reportID = $this->argument('report_id');
        if ($reportID == -1) {
            $reportID = $this->ask($this->reportIDPrompt);
        }
        while (!in_array($reportID, array_keys($this->reportTypes))) {
            $this->error('Incorrect Report Option');
            $reportID = $this->ask($this->reportIDPrompt);
        }

        //GenerateReport($studentID, $reportID)
    }
}
