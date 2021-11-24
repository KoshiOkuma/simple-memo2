@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header">
        メモ編集
        <form action="{{ route('destroy')}}" method="post">
            @csrf
            <input type="hidden" name="memo_id" value="{{ $edit_memo['id'] }}">
            <button type="submit">削除</button>
        </form>
    </div>
    <form class="card-body" action="{{ route('update') }}" method="post">
        @csrf
        <input type="hidden" name="memo_id" value="{{ $edit_memo['id'] }}">
        <div class="form-group">
            <textarea class="form-control" name="content" rows="3" placeholder="ここに入力">{{ $edit_memo['content'] }}</textarea>
          </div>
          <button type="submit" class="btn btn-primary">更新</button>
        </form>
  </div>
@endsection
