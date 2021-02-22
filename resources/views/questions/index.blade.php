@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('questions.create') }}" class="btn btn-outline-primary">Ask a Question!</a>
                </div>
                <div class="card">
                    <div class="card-header">All Questions</div>
                    @foreach ($questions as $question)
                        <div class="card-body">
                            <div class="media">
                                <div class="d-flex flex-column statistics">
                                    <div class="votes mb-3 text-center">
                                        <strong class="d-block">{{ $question->votes_count }}</strong>
                                        Votes
                                    </div>
                                    <div class="answers mb-3 text-center">
                                        <strong class="d-block answers {{ $question->answers_style }}">{{ $question->answers_count }}</strong>
                                        Answers
                                    </div>
                                    <div class="views mb-3 text-center">
                                        <strong class="d-block">{{ $question->views_count }}</strong>
                                        Views
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex justify-content-between">
                                        <h4><a href="{{ $question->url }}">{{$question->title}}</a></h4>
                                        <div class="d-flex justify-content-between">
                                            @can('update', $question)
                                                <div class="mr-1">
                                                    <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                                </div>
                                            @endcan
                                            @can('delete', $question)
                                                <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you Sure You Want To Delete')" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <p>
                                        Asked By: <a href="#">{{ $question->owner->name }}</a>
                                        <span class="text-muted">| Asked: {{ $question->created_date }}</span>
                                    </p>
                                    <p>{!! Str::limit($question->body, 250) !!}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="card-footer">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

