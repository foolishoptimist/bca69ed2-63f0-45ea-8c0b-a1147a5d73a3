<?php

namespace App\Models;

use App\Models\JsonModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends JsonModel
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'yearLevel'
    ];

    /**
     * Return path to model data
     */
    public static function getJsonDataPath() {
        return 'database/data/students.json';
    }

    public function getName() {
        return $this->firstName . ' '. $this->lastName;
    }

    /**
     * Generate Diagnostic Report
     */
    public function diagnosticReport() {
        // Get most recent completed assessment response
        $responses = StudentResponse::where('studentId', $this->id)->whereNotNull('completed')->sortBy('studentYearLevel')->keyBy('assessmentId');
        if (empty($responses)) {
            return "Student has not completed any assessments.";
        }
        $output = "";
        foreach ($responses as $response) {
            $assessment = Assessment::findById($response->assessmentId);
            $questionResponses = collect($response->responses)->pluck('response', 'questionId');
            $questions = Question::all()->whereIn('id', $questionResponses->keys()->toArray());
            $strands = $questions->pluck('strand', 'strand');
            if ($output) {
                $output .= "\n\n";
            }
            $output .= "{$this->getName()} recently completed {$assessment->name} assessment on {$response->getCompletionDate('jS F Y h:i A')}\n";
            $output .= "He got {$response->results['rawScore']} questions right out of " . count($response->responses) . ". Details by strand given below:\n";


            foreach ($strands as $strand) {
                $strandQuestions = $questions->where('strand', $strand);
                $strandScore = (int)$strandQuestions->reduce(function (?int $carry, $question) use ($questionResponses) {
                    $carry += $question->config['key'] == $questionResponses[$question->id] ? 1 : 0;
                    return $carry;
                });
                $output .= "\n{$strand}: {$strandScore} out of " . count($strandQuestions) . " correct";
            }
        }
        return $output;
    }

    /**
     * Generate Progress Report
     */
    public function progressReport() {
        // Get completed assessment response history
        $responses = StudentResponse::where('studentId', $this->id)->whereNotNull('completed');
        $assessmentIds = $responses->pluck('assessmentId','assessmentId');
        if (empty($responses)) {
            return "Student has not completed any assessments.";
        }
        $output = '';
        foreach ($assessmentIds as $assessmentId) {
            $assessment = Assessment::findById($assessmentId);
            $assessmentResponses = $responses->where('assessmentId', $assessmentId)->sortBy('completed');
            if ($output) {
                $output .= "\n\n";
            }
            $output .= "{$this->getName()} has completed {$assessment->name} assessment " . count($assessmentResponses) . " times in total. Date and raw score given below:\n";

            $oldestResult = $newestResult = 0;
            foreach ($assessmentResponses as $assessmentResponse) {
                $newestResult = $assessmentResponse->results['rawScore'];
                $oldestResult = $oldestResult == 0 ? $newestResult : $oldestResult;
                $output .= "\nDate: {$assessmentResponse->getCompletionDate('jS F Y')}, Raw Score: {$newestResult} out of " . count($assessmentResponse->responses);
            }

            if (count($assessmentResponses) > 1) {
                $difference = $newestResult - $oldestResult;
                if ($difference > 0) {
                    $output .= "\n\n{$this->getName()} got {$difference} more correct in the recent completed assessment than the oldest";
                }
            }
        }
        return $output;
    }

    /**
     * Generate Feedback Report
     */
    public function feedbackReport() {
        // Get most recent completed assessment response
        $responses = StudentResponse::where('studentId', $this->id)->whereNotNull('completed')->sortBy('studentYearLevel')->keyBy('assessmentId');
        if (empty($responses)) {
            return "Student has not completed any assessments.";
        }
        $output = "";
        foreach ($responses as $response) {
            $assessment = Assessment::findById($response->assessmentId);
            $questionResponses = collect($response->responses)->pluck('response', 'questionId');
            $questions = Question::all()->whereIn('id', $questionResponses->keys()->toArray())->KeyBy('id');
            if ($output) {
                $output .= "\n\n";
            }
            $output .= "{$this->getName()} recently completed {$assessment->name} assessment on {$response->getCompletionDate('jS F Y h:i A')}\n";
            $output .= "He got {$response->results['rawScore']} questions right out of " . count($response->responses) . ".";
            if ($response->results['rawScore'] < count($response->responses)) {
                $output .= " Feedback for wrong answers given below:";

                foreach ($questionResponses as $questionId => $questionResponse) {
                    $question = $questions[$questionId];
                    if ($question['config']['key'] != $questionResponse) {
                        $options = collect($question['config']['options'])->keyBy('id');
                        $output .= "\n\nQuestion: {$question['stem']}\n";
                        $output .= "Your answer: {$options[$questionResponse]['label']} with value {$options[$questionResponse]['value']}\n";
                        $output .= "Right answer: {$options[$question['config']['key']]['label']} with value {$options[$question['config']['key']]['value']}\n";
                        $output .= "Hint: {$question['config']['hint']}";
                    }
                }
            }

        }
        return $output;
    }
}
