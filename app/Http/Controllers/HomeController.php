<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $memos = Memo::select('memos.*')
        ->where('user_id', '=', Auth::id())
        ->whereNull('deleted_at')
        ->orderBy('updated_at', 'desc')
        ->get();

        // dd($memos);

        return view('create', compact('memos'));
    }

    public function store(Request $request)
    {
        $posts = $request->all();
        // dd($posts['content']);

        Memo::insert([
            'content' => $posts['content'],
            'user_id' => Auth::id()
            ]);

        return redirect()->route('home');

    }

    public function edit($id)
    {
        $memos = Memo::select('memos.*')
        ->where('user_id', '=', Auth::id())
        ->whereNull('deleted_at')
        ->orderBy('updated_at', 'desc')
        ->get();

        $edit_memo = Memo::findOrFail($id);

        return view('edit', compact('memos', 'edit_memo'));
    }


}
