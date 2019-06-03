<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $question->answers()->create(
            $request->validate([
                'body' => 'required'
            ]) +
            ['user_id' => \Auth::id()]
        );

        return back()->with('success', "Your answer has been submitted successfully");
    }

    /**
     * @param Question $question
     * @param Answer $answer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('answers.edit', compact('question','answer'));
    }

    /**
     * @param Request $request
     * @param Question $question
     * @param Answer $answer
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required',
        ]));

        if ($request->expectsJson()) {
            return response()->json([
                'message' =>  "Your answer has been updated",
                'body_html' => $answer->body_html
            ]);
        }


        return redirect()->route('questions.show', $question->slug)->with('success', "Your answer has been updated");
    }


    /**
     * @param Question $question
     * @param Answer $answer
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        if (request()->expectsJson())
        {
            return response()->json([
                'message' =>  "Your answer has been removed"
            ]);
        }

        return back()->with("success", "Your answer has been removed");
    }

}
