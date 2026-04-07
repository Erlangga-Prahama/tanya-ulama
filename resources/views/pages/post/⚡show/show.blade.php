
<div>
    {{$question->title}}
    {!! $question->content !!}
    Dibuat: {{ $question->created_at->diffForHumans() }}
    
</div>