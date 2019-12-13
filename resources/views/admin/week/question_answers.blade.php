<table class="table table-bordered">
    <tbody>
        @if (isset($week) && $week->questions->count() > 0)
            @foreach ($week->questions as $key => $question)
                <tr>
                    <td rowspan="{{ sizeof($question->answers)+1 }}" style="width: 40%">{{ $key+1 }}, {{ $question->title }}</td>
                </tr>

                @foreach ($question->answers as $answer)
                <tr>
                    <td style="width: 50%; @if ($answer->is_correct == 1) font-weight: bold; @endif" >{{ $answer->content}}</td>
                    <td style="width: 10%" align="center">
                        @if ($answer->is_correct == 1)
                            <i class="fa fa-check" aria-hidden="true" style="color: red"></i>
                        @else
                            <i class="fa fa-times" aria-hidden="true" style="color: gray"></i>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endforeach
        @else
            Chưa có câu hỏi.
        @endif
    </tbody>
</table>
