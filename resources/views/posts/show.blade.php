@extends('layouts/app')

@section('content')
    <h1>{{$post->title}}</h1>

    {!! $post->safe_html_content !!}

    @if (auth()->check())
        @if (!auth()->user()->isSubscribedTo($post))
            {!!  Form::open(['route' => ['posts.subscribe', $post], 'method' => 'POST']) !!}
                <button type="submit">Suscribirse al post</button>
            {!! Form::close() !!}
        @else
            {!!  Form::open(['route' => ['posts.unsubscribe', $post], 'method' => 'DELETE']) !!}
            <button type="submit">Desuscribirse al post</button>
            {!! Form::close() !!}
        @endif
    @endif

    <h4>Comentarios</h4>

    {!!  Form::open(['route' => ['comments.store', $post], 'method' => 'POST']) !!}

    {!! \Styde\Html\Facades\Field::textarea('comment') !!}

    <button type="submit">
        Publicar comentario
    </button>

    {!! Form::close() !!}

    @foreach($post->latestComments as $comment)
        <article class="{{ $comment->answer ?'answer' : '' }}">
            {{ $comment->comment }}
            {{--@can('accept', $comment)--}}
            @if(Gate::allows('accept', $comment) && !$comment->answer))
            {!! Form::open(['route' => ['comments.accept', $comment], 'method' => 'POST']) !!}
            <button type="submit">Aceptar respuesta</button>
            {!! Form::close() !!}
            @endif
        </article>

    @endforeach

@endsection