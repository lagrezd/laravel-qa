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

        return redirect()->route('questions.show', $question->slug)->with('success', "Your answer has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return back()->with("success", "Your answer has been removed");
    }
}
