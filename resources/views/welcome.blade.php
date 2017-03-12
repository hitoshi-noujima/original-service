@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <?php $user = Auth::user(); ?>
        <div class="row">
            <aside class="col-xs-4">
                @include('commons.right_column')
            </aside>
            <div class="col-xs-8">
                {!! Form::open(['route' => 'posts.store', 'files' => true, 'class' => 'form-inline']) !!}
                    <div class="form-group mr-10">
                        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '5']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('image', '画像アップロード', ['class' => 'control-label']) !!}
                        {!! Form::file('image') !!}
                    
                        {!! Form::submit('投稿する', ['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
               
                @if (count($posts) > 0)
                    @include('posts.posts', ['posts' => $posts])
                @endif
            </div>
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>ようこそ！！</h1>
                {!! link_to_route('signup.get', '新規登録', null, ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection
