<div class="clearfix">
    <div class="pull-left mr-10">
        <img class="media-object img-thumbnail img-responsive" src="{{ Gravatar::src($user->email, 80) }}" alt="{{ $user->name }}">
    </div>
    <div class="pull-left">
        {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!}
    </div>
</div>
<div class="clearfix text-center mt-20">
    <div class="pull-left mr-10">
        フォロー<br>{!! link_to_route('users.followings', $count_followings, ['id' => $user->id]) !!}</a>
    </div>
    <div class="pull-left mr-10">
        フォロワー<br>{!! link_to_route('users.followers', $count_followers, ['id' => $user->id]) !!}</a>
    </div>
    <div class="pull-left">
        イイね<br>{!! link_to_route('users.favorites', $count_favorites, ['id' => $user->id]) !!}</a>
    </div>
</div>
