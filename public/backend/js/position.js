"use strict";

function addPosTxtItem(key, value)
{
    key = key || '';
    value = value || '';
    var tpl = `
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">键</span>
                            </div>
                            <input type="text" autocomplete="off" class="form-control" name="pos_text_key[]" value="${key}" />
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">值</span>
                            </div>
                            <textarea class="form-control" autocomplete="off" name="pos_text_value[]" style="height:60px;">${value}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-2" style="line-height:70px;">
                    <div class="pos-ext-item__border">&nbsp;</div>
                    <a href="javascript:;" class="pos-txt__remove">&times;删除</a>
                </div>
            </div>
        `;
    $('.pos-txt-list').append(tpl);
}

function addPosImgItem(key, value)
{
    key = key || '';
    value = value || '';
    var numImgUploders = $('.pos-image-uploader').length;
    var imgId = 'image-uploader-' + (++ numImgUploders);
    var tpl = `
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">键</span>
                            </div>
                            <input type="text" autocomplete="off" class="form-control" name="pos_img_key[]" value="${key}" />
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">图</span>
                            </div>

                            <div class="pos-image-uploader" id="${imgId}">
                                <input type="file" class="form-control J_uploadFile" default-val="${value}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2" style="line-height:70px;">
                    <div class="pos-ext-item__border" style="">&nbsp;</div>
                    <a href="javascript:;" class="pos-img__remove">&times;删除</a>
                </div>
            </div>
        `;

    $('.pos-img-list').append(tpl);
    $("#" + imgId).dccUploadFiles({
        //width:100,
        //height:100,
        max: 1,//最多上传图片数量
        uploadUrl:"/admin/uploadBanner",
        name: 'pos_img_value[]',
        // delUrl:"/Upload/deleteAjax",//不进行服务器端物理删除则可以不写
    });
}

$(function () {
    var $posTxtList = $('.pos-txt-list');
    var $posImgList = $('.pos-img-list');

    $('.btn-add-pos-txt').on('click', function () {
        addPosTxtItem();
    });

    $posTxtList.on('click', '.pos-txt__remove', function () {
        $(this).parent().parent().fadeOut('fast', function () {
            $(this).remove();
        });
    });

    $('.btn-add-pos-img').on('click', function () {
        addPosImgItem();
    });

    $posImgList.on('click', '.pos-img__remove', function () {
        $(this).parent().parent().fadeOut('fast', function () {
            $(this).remove();
        });
    });

    $(".pos-image-uploader").dccUploadFiles({
        //width:100,
        //height:100,
        max: 1,//最多上传图片数量
        uploadUrl:"/admin/uploadBanner",
        // delUrl:"/Upload/deleteAjax",//不进行服务器端物理删除则可以不写
    });
});