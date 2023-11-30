<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandTest extends TestCase
{
    /**
     * Test AssessmentReports Command <student1 1>
     */
    public function test_assessment_reports_diagnostic(): void
    {

        $this->artisan('app:assessment-report student1 1')
        ->expectsOutput("Tony Stark recently completed Numeracy assessment on 16th December 2021 10:46 AM
He got 15 questions right out of 16. Details by strand given below:

Numeracy and Algebra: 5 out of 5 correct
Measurement and Geometry: 7 out of 7 correct
Statistics and Probability: 3 out of 4 correct")
        ->assertExitCode(0);
    }

    /**
     * Test AssessmentReports Command <student1 2>
     */
    public function test_assessment_reports_progress(): void
    {

        $this->artisan('app:assessment-report student1 2')
        ->expectsOutput("Tony Stark has completed Numeracy assessment 3 times in total. Date and raw score given below:

Date: 14th December 2019, Raw Score: 6 out of 16
Date: 14th December 2020, Raw Score: 10 out of 16
Date: 14th December 2021, Raw Score: 15 out of 16

Tony Stark got 9 more correct in the recent completed assessment than the oldest")
        ->assertExitCode(0);
    }

    /**
     * Test AssessmentReports Command <student1 3>
     */
    public function test_assessment_reports_feedback(): void
    {

        $this->artisan('app:assessment-report student1 3')
        ->expectsOutput("Tony Stark recently completed Numeracy assessment on 16th December 2021 10:46 AM
He got 15 questions right out of 16. Feedback for wrong answers given below

Question: What is the 'median' of the following group of numbers 5, 21, 7, 18, 9?
Your answer: A with value 7
Right answer: B with value 9
Hint: You must first arrange the numbers in ascending order. The median is the middle term, which in this case is 9")
        ->assertExitCode(0);
    }
}
