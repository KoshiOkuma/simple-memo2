@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header">メモ変数</div>
    <form class="card-body" action="{{ route('store') }}" method="post">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" rows="3" placeholder="ここに入力">
                {{ $edit_memo['content'] }}
            </textarea>
          </div>
          <button type="submit" class="btn btn-primary">更新</button>
        </form>
  </div>
@endsection
