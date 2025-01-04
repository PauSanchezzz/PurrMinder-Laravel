<?php

namespace App\Http\Controllers;

use App\Models\AnswerQuestions;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdoptionApplications extends Controller
{
    public function catRequested()
    {
        $cats = AnswerQuestions::select('answerQuestions.application_id', 'cats.nameCat', 'cats.imageCat')
            ->join('adoptionApplication', 'adoptionApplication.id', '=', 'answerQuestions.application_id')
            ->join('cats', 'cats.id', '=', 'adoptionApplication.cat_id')
            ->join('evaluation', 'evaluation.application_id', '=', 'adoptionApplication.id')
            ->where('evaluation.evaluationStatus_id', '=', 3)
            ->distinct('answerQuestions.application_id')
            ->get();

        return response()->json(['cats' => $cats], 200);
    }

    public function getQuestionsAndAnswers($applicationId)
    {
        $questionsAndAnswers = AnswerQuestions::select('questionsForm.question', 'answerQuestions.answer', 'answerQuestions.application_id')
            ->join('questionsForm', 'questionsForm.id', '=', 'answerQuestions.question_id')
            ->where('answerQuestions.application_id', $applicationId)
            ->get();

        return response()->json(['questions_and_answers' => $questionsAndAnswers], 200);
    }

    public function getUserByApplicationId($applicationId)
    {
        $user = AnswerQuestions::select('users.name', 'users.lastName', 'users.telephoneNumber', 'occupation.occupation')
            ->join('adoptionApplication', 'adoptionApplication.id', '=', 'answerQuestions.application_id')
            ->join('users', 'users.id', '=', 'adoptionApplication.adopter_id')
            ->join('occupation', 'users.occupation', '=', 'occupation.idOccupation')
            ->where('answerQuestions.application_id', $applicationId)
            ->distinct('answerQuestions.application_id')
            ->first();

        return response()->json(['user' => $user], 200);
    }

    public function getCatByApplicationId($applicationId)
    {
        $cat = AnswerQuestions::select(
            'cats.nameCat',
            'cats.imageCat',
            'cats.ageCat',
            'calendar.calendar',
            'cats.weightCat',
            'sex.sex'
        )
            ->join('adoptionApplication', 'adoptionApplication.id', '=', 'answerQuestions.application_id')
            ->join('cats', 'cats.id', '=', 'adoptionApplication.cat_id')
            ->join('calendar', 'cats.calendar_id', '=', 'calendar.idCalendar')
            ->join('sex', 'cats.sexCat_id', '=', 'sex.idSex')
            ->where('answerQuestions.application_id', $applicationId)
            ->distinct()
            ->first();


        return response()->json(['cat' => $cat], 200);
    }

    public function updateResponseEvaluation(Request $request, $application_id)
    {
        $request->validate([
            'comments' => 'required|string',
            'application_id' => '',
            'evaluationStatus_id' => 'required|integer',
        ]);
        $evaluation = Evaluation::where('application_id', $application_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($evaluation) {
            $evaluation->comments = $request->comments;
            $evaluation->evaluationStatus_id = $request->evaluationStatus_id;
            $evaluation->save();

            return response()->json(['message' => 'Evaluation updated successfully.', 'status' => 200], 200);
        }
        return response()->json(['message' => 'Evaluation not found.'], 404);

    }

    public function detailAdoptions()
    {
        $cats = AnswerQuestions::from('answerQuestions as aq')
            ->select('c.nameCat', 'aq.created_at', 'e.updated_at', 'e.comments', 'es.evaluation')
            ->join('adoptionApplication as aa', 'aa.id', '=', 'aq.application_id')
            ->join('cats as c', 'c.id', '=', 'aa.cat_id')
            ->join('evaluation as e', 'e.application_id', '=', 'aa.id')
            ->join('evaluationStatus as es', 'e.evaluationStatus_id', '=', 'es.id')
            ->whereIn('e.evaluationStatus_id', [1, 2])
            ->distinct('aq.application_id')
            ->get();



        return response()->json(['cats' => $cats], 200);
    }

    public function detailAdoptionsFilter(Request $request)
    {
        $request->validate([
            'fecha_inicio' => '',
            'fecha_fin' => '',
        ]);

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $cats = AnswerQuestions::from('answerQuestions as aq')
            ->select('c.nameCat', 'aq.created_at', 'e.updated_at', 'e.comments', 'es.evaluation')
            ->join('adoptionApplication as aa', 'aa.id', '=', 'aq.application_id')
            ->join('cats as c', 'c.id', '=', 'aa.cat_id')
            ->join('evaluation as e', 'e.application_id', '=', 'aa.id')
            ->join('evaluationStatus as es', 'e.evaluationStatus_id', '=', 'es.id')
            ->whereIn('e.evaluationStatus_id', [1, 2])
            ->whereBetween('e.updated_at', [$fechaInicio, $fechaFin])
            ->distinct('aq.application_id')
            ->get();

        return response()->json(['cats' => $cats], 200);
    }
}
