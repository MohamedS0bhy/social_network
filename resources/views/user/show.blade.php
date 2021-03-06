@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <img src="{{ $user->profile_picture }}" alt="">
                      {{ $user->username }}
                    <div class="pull-right"  data-friendid=" {{$user->id}} " >
                    	<a href="" class="btn btn-link friend">Add Friend</a>
                    	<a href="#" class="btn btn-link">ViewFriend</a>

                    </div>

                    </h3>
                </div>
                <div class="panel-body">
                    <div>
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#posts" aria-controls="posts" role="tab" data-toggle="tab">Your Posts</a></li>
                        <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
                        <li role="presentation"><a href="#categories" aria-controls="categories" role="tab" data-toggle="tab">Categories</a></li>
                        <li role="presentation"><a href="#likes" aria-controls="likes" role="tab" data-toggle="tab">Liked Posts</a></li>
                        <li role="presentation"><a href="#tag" aria-controls="likes" role="tab" data-toggle="tab">View Tags</a></li>
                      </ul>
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active fade in" id="posts">
                            {{ $user->posts()->count() }} Posts created
                            @foreach ($user->posts as $post)
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title">
                                        {{ $post->title }}
                                        <div class="pull-right">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                    <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="{{ route('post.show', [$post->id]) }}">Show Post</a></li>
                                                    <li><a href="{{ route('post.edit', [$post->id]) }}">Edit Post</a></li>
                                                    <li>
                                                        <a href="#" onclick="document.getElementById('delete').submit()">Delete Post</a>
                                                        {!! Form::open(['method' => 'DELETE', 'id' => 'delete', 'route' => ['post.delete', $post->id]]) !!}
                                                        {!! Form::close() !!}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </h3>
                                  </div>
                                  <div class="panel-body">
                                    {{ $post->body }}
                                    <br />
                                    Ctegory : <div class="badge">
                                      <a  href="/social/public/post/category/{{$post->category_id}}" class="badge">
                                   {{ $post->category['name']  }}


                                   </a></div>
                                  </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- comments starts -->
                        <div role="tabpanel" class="tab-pane fade" id="comments">
                            {{ $user->comments()->count() }} Commments created
                   @foreach($user->comments as $comment )

                <div class="panel panel-default" style="margin: 0; border-radius: 0;">
                  <div class="panel-body">
                      <div class="col-sm-9">
                          {{ $comment->comment  }}
                      </div>
                      <div class="col-sm-3">
                          <small> <a href=" {{route('post.show',[$comment->post->id])}} ">View Post </a> </small>
                      </div>
                  </div>
                </div>

                @endforeach
                        </div>
                        <!-- Comments ends  -->
                        <div role="tabpanel" class="tab-pane fade" id="categories">
                            {{ $user->categories()->count() }} Categoreies created
                            @foreach ($user->categories as $category)
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                    Ctegory : <div class="badge">
                                      <a  href="/social/public/post/category/{{$post->category_id}}" class="badge">
                                   {{ $post->category['name']  }}


                                   </a></div>
                                  </div>
                                </div>
                            @endforeach
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="likes">
                            @foreach ($user->likes as $like)
                                @if ($like->like)
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        <h3 class="panel-title">
                                            Created by {{ $like->post->user->username }}, {{ $like->post->title }}
                                            <div class="pull-right">
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                        <span class="caret"></span>
                                                    </a>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ route('post.show', [$like->post->id]) }}">Show Post</a></li>
                                                        <li><a href="{{ route('post.edit', [$like->post->id]) }}">Edit Post</a></li>
                                                        <li>
                                                            <a href="#" onclick="document.getElementById('delete').submit()">Delete Post</a>
                                                            {!! Form::open(['method' => 'DELETE', 'id' => 'delete', 'route' => ['post.delete', $like->post->id]]) !!}
                                                            {!! Form::close() !!}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </h3>
                                      </div>
                                      <div class="panel-body">
                                        {{ $like->post->body }}
                                        @if ($like->post->image != null)
                                            <img src="/images/{{ $like->post->image }}" alt="Image" width="100%" height="600">
                                        @endif
                                        <br />
                                        Ctegory : <div class="badge">
                                          <a  href="/social/public/post/category/{{$post->category_id}}" class="badge">
                                       {{ $post->category['name']  }}


                                       </a></div>
                                      </div>
                                      <div class="panel-footer" data-postid="{{ $like->post->id }}">
                                        <a href="#" class="btn btn-link like active-like">Like <span class="badge">{{ $like->post->likes()->where('like', '=', true)->count() }}</span></a>
                                        <a href="#" class="btn btn-link like">Dislike <span class="badge">{{ $like->post->likes()->where('like', '=', false)->count() }}</a>
                                         <a href="{{ route('post.show', [$like->post->id]) }}" class="btn btn-link">Comment</a>
                                      </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                     <!--start tag  -->

                <!-- end tag  -->
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
