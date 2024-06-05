<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::all();
        return view('pages.faq', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.addFaq');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string',
            'subquestions.*' => 'required|string',
            'answers.*' => 'required|string',
        ]);

        $faq = FAQ::create([
            'big_title' => $validatedData['question'],
            'subquestions_answers' => array_map(function ($subquestion, $answer) {
                return ['subquestion' => $subquestion, 'answer' => $answer];
            }, $validatedData['subquestions'], $validatedData['answers']),
        ]);

        return redirect()->route('faq.index')->with('success', 'FAQ added successfully!');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $faq = FAQ::findOrFail($id);
        return view('pages.editFaq', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'big_title' => 'required|string',
            'subquestions' => 'required|array',
            'answers' => 'required|array',
        ]);
    
        $faq = FAQ::findOrFail($id);
    
        $faq->big_title = $validatedData['big_title'];
    
        // Combine subquestions and answers into subquestions_answers array
        $subquestionAnswerPairs = [];
        foreach ($validatedData['subquestions'] as $index => $subquestion) {
            $subquestionAnswerPairs[] = [
                'subquestion' => $subquestion,
                'answer' => $validatedData['answers'][$index],
            ];
        }
    
        $faq->subquestions_answers = $subquestionAnswerPairs;
        $faq->save();
    
        return redirect()->route('faq.index')->with('success', 'FAQ updated successfully!');
    }
    


    public function destroy($id)
    {
        $faq = FAQ::findOrFail($id);
        $faq->delete();

        return redirect()->route('faq.index')->with('success', 'FAQ deleted successfully!');
    }

    /**
     * Remove the specified subquestion and answer from storage.
     */
    public function destroySub($faqId, $subIndex)
    {
        $faq = FAQ::findOrFail($faqId);
        $subquestions_answers = $faq->subquestions_answers;
        
        if (isset($subquestions_answers[$subIndex])) {
            unset($subquestions_answers[$subIndex]);
            $faq->subquestions_answers = array_values($subquestions_answers); // Reindex the array
            $faq->save();
        }

        return redirect()->back()->with('success', 'Subquestion and answer deleted successfully.');
    }

}
