<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\MemoTag;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

        $tags = Tag::where('user_id', '=', Auth::id())
        ->whereNull('deleted_at')
        ->orderBy('id', 'desc')
        ->get();

        // dd($tags);

        return view('create', compact('memos', 'tags'));
    }

    public function store(Request $request)
    {
        $posts = $request->all();
        // dd($posts);

        DB::transaction(function () use($posts)
        {
            $memo_id = Memo::insertGetId([
                'content' => $posts['content'],
                'user_id' => Auth::id(),
            ]);
            $tag_exists = Tag::where('user_id', '=', Auth::id())
            ->where('name', '=', $posts['new_tag'])
            ->exists();

            if(!empty($posts['new_tag']) && !$tag_exists )
            {
                $tag_id = Tag::insertGetId([
                    'user_id' => Auth::id(),
                    'name' => $posts['new_tag']
                ]);

                MemoTag::insert([
                    'memo_id' => $memo_id,
                    'tag_id' => $tag_id
                ]);
            }
            // 既存タグが紐付けられた場合
            if(!empty($posts['tags'][0]))
            {
                foreach($posts['tags'] as $tag){
                    MemoTag::insert([
                        'memo_id' => $memo_id,
                        'tag_id' => $tag
                        ]);
                    }
            }
        });

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

    public function update(Request $request)
    {
        $posts = $request->all();
        // dd($posts);

        Memo::where('id', $posts['memo_id'])
        ->update([
            'content' => $posts['content'],
            ]);

        return redirect()->route('home');
    }

    public function destroy(Request $request)
    {
        $posts = $request->all();
        // dd($posts);

        Memo::where('id', $posts['memo_id'])
        ->update([
            'deleted_at' => date("Y-m-d H:i:s", time()),
        ]);

        return redirect()->route('home');
    }


}
