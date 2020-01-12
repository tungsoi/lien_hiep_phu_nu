<table border="1">
    <thead>
    <tr>
        <th style="width: 10px; text-align: center;">STT</th>
        <th style="width: 20px; text-align: center;">Tên tuần thi</th>
        <th style="width: 20px; text-align: center;">Ngày bắt đầu</th>
        <th style="width: 20px; text-align: center;">Ngày kết thúc</th>
        <th style="width: 20px; text-align: center;">Số lượng câu hỏi</th>
        <th style="width: 20px; text-align: center;">Người tạo</th>
        <th style="width: 20px; text-align: center;">Trạng thái</th>
        <th style="width: 20px; text-align: center;">Số lượt trả lời</th>
        <th style="width: 20px; text-align: center;">Số người trả lời đúng</th>
    </tr>
    </thead>
    <tbody>
    @foreach($weeks as $key => $week)
        <tr>
            <td style="width: 10px; text-align: center;">{{ $key+1 }}</td>
            <td style="width: 20px; text-align: center;">{{ $week->name }}</td>
            <td style="width: 20px; text-align: center;">{{ date('H:i - d/m/Y', strtotime($week->date_start)) }}</td>
            <td style="width: 20px; text-align: center;">{{ date('H:i - d/m/Y', strtotime($week->date_end)) }}</td>
            <td style="width: 20px; text-align: center;">{{ sizeof($week->questions) }}</td>
            <td style="width: 20px; text-align: center;">{{ $week->userCreated->name }}</td>
            <td style="width: 20px; text-align: center;">
                @switch($week->status)
                    @case(0)
                        {{ trans('admin.not_started') }}
                        @break
                    @case(1)
                        {{ trans('admin.running') }}
                        @break
                    @case(2)
                        {{ trans('admin.stop') }}
                        @break
                    @default
                        {{ null }}
                @endswitch
            </td>
            <td style="width: 20px; text-align: center;">{{ $week->memberExam->count() }}</td>
            <td style="width: 20px; text-align: center;">{{ $week->countNumberUserCorrect($week->id) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
