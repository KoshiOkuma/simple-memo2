@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header">
        メモ編集
        <form action="{{ route('destroy')}}" method="post">
            @csrf
            <input type="hidden" name="memo_id" value="{{ $edit_memo[0]['id'] }}">
            <button type="submit">削除</button>
        </form>
    </div>
    <form class="card-body" action="{{ route('update') }}" method="post">
        @csrf
        <input type="hidden" name="memo_id" value="{{ $edit_memo[0]['id'] }}">
        <div class="form-group">
            <textarea class="form-control" name="content" rows="3" placeholder="ここに入力">{{ $edit_memo[0]['content'] }}</textarea>
          </div>
          @foreach ($tags as $tag )
          <div class="form-check form-check-inline mb-3">
              <input type="checkbox" name="tags[]" id="{{$tag['id']}}" value="{{$tag['id']}}" class="form-check-input" {{ in_array($tag['id'], $include_tags) ? 'checked' : '' }}>
              <label for="{{$tag['id']}}"class="form-check-label">{{$tag['name']}}</label>
          </div>
          @endforeach
          <input type="text" name="new_tag" class="form-control w-50 mb-3" placeholder="新しいタグ">
          <button type="submit" class="btn btn-primary">更新</button>
        </form>
  </div>
@endsection
