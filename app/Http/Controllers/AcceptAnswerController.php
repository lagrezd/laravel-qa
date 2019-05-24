<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AcceptAnswerController extends Controller
{
    /**
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);

        $answer->question->acceptBestAnswer($answer);

        return back();
    }
}
