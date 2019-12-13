<?php

namespace App\Admin\Extensions\Show;

use Brazzer\Admin\Show\AbstractField;

class QuestionHaveAnswer extends AbstractField
{
    public function render()
    {
        // return any content that can be rendered
        // return view('admin.week.question_answers')->render();/z

        return '<div class="btn-group-management">
        <div class="btn-group btn-group-xs pull-left">
            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#mdlSgoRejectReport" id="btnSgoRejectReport">Trả lại</button>
        </div>
        <div class="btn-group btn-group-xs pull-left" style="margin-left: 10px">
            <button type="button" class="btn btn-success btn-xs" id="btnSgoConfirm">Tiếp nhận</button>
        </div>
    </div>
    <div class="btn-group-handle-report" style="display: none">
        <div class="btn-group btn-group-xs pull-left" style="margin-left: 10px">
            <button type="button" class="btn btn-primary btn-xs" id="btnSubmitSgoConfirm">Cập nhật</button>
        </div>
        <div class="btn-group btn-group-xs pull-left" style="margin-left: 10px">
            <button type="button" class="btn btn-danger btn-xs" id="btnSubmitSgoClose">Đóng báo cáo</button>
        </div>
    </div>
    <div>
        <!-- Modal Reject Report -->
        <div id="mdlSgoRejectReport" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">SGO Trả lại báo cáo tiếp viên</h4>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn trả lại báo cáo này ?</p>
                    <div class="form-group form-group-xs">
                        <p for="reason" class="col-xs-2 control-label" style="font-size:12px">Lý do trả lại: </p>
                        <div class="col-xs-12">
                            <textarea name="reason" class="form-control reason" rows="6" placeholder="Vui lòng nhập vào lý do từ chối" required="true"></textarea>
                        </div>
                    </div>';
    }
}
