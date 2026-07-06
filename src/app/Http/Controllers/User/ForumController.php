<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ForumQuestion;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ForumController extends Controller
{
    public function index(): View
    {
        $questions = ForumQuestion::with('user', 'replies')
            ->latest()
            ->paginate(15);
            
        return view('user.forum.index', [
            'questions' => $questions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        ForumQuestion::create($validated);

        return redirect()->route('user.forum.index')
            ->with('success', 'Pertanyaan Anda berhasil dipublikasikan!');
    }

    public function show(ForumQuestion $question): View
    {
        $question->load(['user', 'replies.user']);
        
        return view('user.forum.show', [
            'question' => $question,
        ]);
    }

    public function storeReply(Request $request, ForumQuestion $question): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $question->replies()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return redirect()->route('user.forum.show', $question)
            ->with('success', 'Balasan berhasil dikirim!');
    }
}
