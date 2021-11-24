@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-header">新規メモ作成</div>
    <form class="card-body" action="{{ route('store') }}" method="post">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" rows="3" placeholder="ここに入力"></textarea>
          </div>
          @foreach ($tags as $tag )
          <div class="form-check form-check-inline mb-3">
              <input type="checkbox" name="tags[]" id="{{$tag['id']}}" value="{{$tag['id']}}">
              <label for="{{$tag['id']}}">{{$tag['name']}}</label>
          </div>
          @endforeach
          <input type="text" name="new_tag" class="form-control w-50 mb-3" placeholder="新しいタグ">
          <button type="submit" class="btn btn-primary">保存</button>
    </form>
  </div>
@endsection
