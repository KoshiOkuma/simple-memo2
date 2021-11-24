@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header">
        メモ編集
        <form action="{{ route('destroy')}}" method="post" id="delete-form">
            @csrf
            <input type="hidden" name="memo_id" value="{{ $edit_memo[0]['id'] }}">
            <i class="fas fa-trash" onclick="deleteHandle(event)"></i>
        </form>
    </div>
    <form class="card-body" action="{{ route('update') }}" method="post">
        @csrf
        <input type="hidden" name="memo_id" value="{{ $edit_memo[0]['id'] }}">
        <div class="form-group">
            <textarea class="form-control" name="content" rows="3" placeholder="ここに入力">{{ $edit_memo[0]['content'] }}</textarea>
          </div>
          @error('content')
          <div class="alert alert-danger">メモ内容を入力してください</div>
          @enderror
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

  <script>
      function deleteHandle(event)
      {
          event.preventDefault();
        if(window.confirm('本当に削除していいですか？'))
        {
            document.getElementById('delete-form').submit();
        } else {
            // alert('キャンセルしました');
        }
      }
  </script>
@endsection
