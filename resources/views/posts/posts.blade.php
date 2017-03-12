<ul class="media-list mt-20">
@foreach ($posts as $post)
    <?php $user = $post->user; ?>
    <li class="media post">
        <div class="media-left">
            <img class="media-object img-thumbnail" src="{{ Gravatar::src($user->email, 40) }}" alt="{{ $user->name }}">
        </div>
        <div class="media-body">
            <div>
                {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!}
                
                @if (Auth::user()->id != $user->id) 
                    @if (Auth::user()->is_following($user->id))
                        {!! Form::open(['route' => ['user.unfollow', $user->id], 'method' => 'delete', 'class' => 'form-inline ml-10']) !!}
                            <button type="submit" class="icon icon-isfollow"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
                            
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(['route' => ['user.follow', $user->id], 'class' => 'form-inline ml-10']) !!}
                            <button type="submit" class="icon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
                            
                        {!! Form::close() !!}
                    @endif
                @endif
            </div>
            <div>
                <p>{!! nl2br(e($post->content)) !!}</p>
            </div>
            
            @if($post->image)
                <div>
                    <img src="{{ trans('aws.url') . $post->image }}" alt="">
                </div>
            @endif
            <div class="mt-20 clearfix">
                <div class="pull-left">
                    @if (Auth::user()->is_favorite($post->id))
                        {!! Form::open(['route' => ['user.removefavorite', $post->id], 'method' => 'delete', 'class' => 'form-inline mr-10']) !!}
                            <button type="submit" class="icon icon-isFav"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></button>
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(['route' => ['user.addfavorite', $post->id], 'class' => 'form-inline mr-10']) !!}
                            <button type="submit" class="icon"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></button>
                        {!! Form::close() !!}
                    @endif
                
                    @if (Auth::user()->id == $post->user_id)
                        <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="icon"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                    @endif
                </div>
                <div class="pull-right">
                    <span class="text-muted"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> {{ $post->updated_at }}</span>
                </div>
            </div>
        </div>
    </li>
@endforeach
</ul>
{!! $posts->render() !!}