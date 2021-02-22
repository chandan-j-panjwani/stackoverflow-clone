<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="mt-0">
                    {{ Str::plural('Answer', $question->answers_count) }}
                </h3>
            </div>
            <div class="card-body">
                @foreach($question->answers as $answer)
                    <div class="d-flex">
                        <div class="d-flex flex-column">
                            <div>
                                @can('vote', $answer)
                                    <form action="{{ route('answers.vote', [$answer->id, 1]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn {{ auth()->user()->hasAnswerUpVote($answer) ? 'text-dark': 'text-black-50' }}">
                                            <i class="fa fa-caret-up fa-3x" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" title="Up Vote" class="vote-up d-block text-center text-black-50">
                                        <i class="fa fa-caret-up fa-3x" aria-hidden="true"></i>
                                    </a>
                                @endcan
                                <h4 class="votes-count text-muted text-center m-0">{{ $answer->votes_count }}</h4>
                                @can('vote', $answer)
                                    <form action="{{ route('answers.vote', [$answer->id, -1]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn {{ auth()->user()->hasAnswerDownVote($answer) ? 'text-dark': 'text-black-50' }}">
                                            <i class="fa fa-caret-down fa-3x" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" title="Up Vote" class="vote-up d-block text-center text-black-50">
                                        <i class="fa fa-caret-down fa-3x" aria-hidden="true"></i>
                                    </a>
                                @endcan
                            </div>

                            <div class="mt-2">
                                @can('markAsBest', $answer)
                                    <form action="{{ route('answers.bestAnswer', $answer->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn {{ $answer->best_answer_status }}" title="Mark as best answer">
                                            <i class="fa fa-check fa-2x"></i>
                                        </button>
                                    </form>
                                @else
                                    @if ($answer->is_best)
                                        <i class="fa fa-check fa-2x d-block text-success"></i>
                                    @endif
                                @endcan
                                <h4 class="votes-count m-0 text-center">123</h4>
                            </div>
                        </div>
                        <div class="ml-5">
                            {!! $answer->body !!}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mr-3">
                        <div>
                            @can('update', $answer)
                                <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan
                            @can('delete', $answer)
                            <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                            @endcan
                        </div>
                        <div class="d-flex flex-column">
                            <div class="text-muted mb-2 text-right">
                                Answered {{ $answer->created_date }}
                            </div>
                            <div class="d-flex mb-2">
                                <div>
                                    <img src="{{ $answer->author->avatar }}" alt="">
                                </div>
                                <div class="mt-2 ml-2">
                                    {{ $answer->author->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
