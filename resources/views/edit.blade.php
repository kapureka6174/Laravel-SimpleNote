@extends('layouts.app')

@section('content')
<div class="row justify-content-center ml-0 mr-0 h-100">
    {{ $user['name'] }}
    <div class="card w-100">
        <div class="card-header">メモ編集</div>
        <div class="card-body">
            <form method='POST' action={{ route('update', ['id' => $memo['id']]) }}>
                @csrf
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">
                <div class="form-group">
                    <textarea name='content' class="form-control" rows="10">{{ $memo['content'] }}</textarea>
                </div>
                <div class="form-group">
                    <select class='form-control' name='tag_id'>
                        @foreach($tags as $tag)
                        <option value="{{ $tag['id'] }}" {{ $tag['id'] == $memo['tag_id'] ? "selected" : "" }}>
                            {{$tag['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <button type='submit' class="btn btn-primary btn-lg">更新</button>
            </form>
        </div>
    </div>
</div>
@endsection
