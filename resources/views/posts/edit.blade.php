@extends('layouts.app')

@section('content')
    
    <div class="row">
        <aside class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $user->name }}</h3>
                </div>
                <div class="panel-body">
                    <img class="media-object img-rounded img-responsive" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                </div>
            </div>
            @include('user_follow.follow_button', ['user' => $user])
        </aside>
        <div class="col-xs-8">
             @include('users.commons.tab')
            
            {!! Form::open(['route' => ['posts.update', $post->id], 'method' => 'put', 'files' => true]) !!}
                <table class="table table-fixed">
                  <tr>
                      <th>ID</th>
                      <td>{{ $post->id }}</td>
                  </tr>
                  <tr>
                      <th>{!! Form::label('content', '投稿') !!}</th>
                      <td>{!! Form::textarea('content', $post->content, ['class' => 'form-control', 'rows' => '5']) !!}</td>
                  </tr>
                  <tr>
                      <th>{!! Form::label('image', '画像アップロード') !!}</th>
                      <td>
                          <table class="table table-fixed">
                              <tr>
                                  <td>
                                        {!! Form::file('image') !!}
                                        @if($post->image)
                                            {!! Form::checkbox('image_delete') !!}
                                            {!! Form::label('image_delete', '画像を削除') !!}
                                        @endif
                                </td>
                                 @if($post->image)
                                      <td>
                                          <div>
                                            <img src="{{ trans('aws.url') . $post->image }}" alt="">
                                        </div>
                                      </td>
                                   @endif
                              </tr>
                          </table>
                      </td>
                      
                  </tr>
                </table>
                
                {!! Form::submit('更新', ['class' => 'btn btn-primary']) !!}
                
            {!! Form::close() !!}
            
            {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'delete', 'class' => 'form-inline']) !!}
                {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection