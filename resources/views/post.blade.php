@extends('layouts.blog-home')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <!-- Blog Post -->

            <!-- Title -->
            <h1>{{$post->title}}</h1>

            <!-- Author -->
            <p class="lead">
                by {{$post->user->name}}
            </p>

            <hr>

            <!-- Date/Time -->
            <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

            <hr>

            <!-- Preview Image -->
            <img class="img-responsive" src="{{$post->photo ? $post->photo->file : $post->photoPlaceHolder()}}" alt="">

            <hr>

            <!-- Post Content -->
            <p class="lead">{!! $post->body !!}</p>


            <hr>

            <!-- Blog Comments -->
            @if(Auth::check())

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    {!! Form::open(['method' => 'POST', 'action' => 'PostCommentsController@store']) !!}
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <div class="form-group">
                            {!! Form::label('body', 'Body:') !!}
                            {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Submit Comment', ['class' => 'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>

            @endif

            <hr>

            <!-- Posted Comments -->

            @if(count($comments) > 0)

                @foreach($comments as $comment)

                    <!-- Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img width="64" height="64" class="media-object" src="{{Auth::user()->gravatar}}" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">{{$comment->author}}
                                <small>{{$comment->created_at->diffForHumans()}}</small>
                            </h4>
                            <p>{{$comment->body}}</p>
                            <hr>

                            @if(count($comment->replies) > 0)
                                @foreach($comment->replies as $reply)
                                    @if($reply->is_active == 1)
                                        <!-- Nested Comment -->
                                        <div id="nested-comment" class="media">
                                            <a class="pull-left" href="#">
                                                <img width="64px" height="64px" class="media-object" src="{{$reply->photo}}" alt="">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{$comment->author}}
                                                    <small>{{$comment->created_at->diffForHumans()}}</small>
                                                </h4>
                                                <p>{{$reply->body}}</p>
                                            </div>
                                        </div>
                                        <!-- End Nested Comment --> 
                                    @endif
                                @endforeach
                                <br>
                            @endif
                    
                            <div class="form-group">
                                <button class="toggle-reply btn btn-info">Reply</button>
                            </div>
                            <div class="comment-reply">
                                {!! Form::open(['method' => 'POST', 'action' => 'CommentRepliesController@createReply']) !!}
                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                    <div class="form-group">
                                        {{-- {!! Form::label('body', 'Body:') !!} --}}
                                        {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 1]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::submit('Submit', ['class' => 'btn btn-info pull-right']) !!}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif
        </div> <!-- col-md-8 -->

        @include('includes.front_sidebar')
    
    </div> <!-- ROW -->
@stop

@section('scripts')
<script>
    $('.toggle-reply').click(function() {

        $('.comment-reply').slideToggle("fast");

    });
</script>

    {{-- <div id="disqus_thread"></div>
    <script>

        /**
        *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        /*
        var disqus_config = function () {
        this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        */
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://codehacking-fer7h0upli.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <script id="dsq-count-scr" src="//codehacking-fer7h0upli.disqus.com/count.js" async></script> --}}

@stop