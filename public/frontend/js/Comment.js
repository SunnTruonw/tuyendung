// (function($) {
//     $.fn.createFormComment = function(option) {
//         var setting = $.extend({
//             //   a: 3,
//         }, option);
//         return this.each(function() {
//             console.log(setting.a);
//         });
//     }
// }(jQuery));
$(function() {
    function callBackCommentAuth() {
        $('#formCommentAuth').submit();
    }
    $(document).on('click', '.btn-send-comment-before', function() {
        let content = $('#content').val();
        if (content) {
            let urlRequest = $(this).data("check");
            $.ajax({
                type: "GET",
                url: urlRequest,
                success: function(response) {
                    if (response.code == 200 && response.data) {
                        callBackCommentAuth();
                    } else {

                        $('#modal-comment').modal('show');
                        $('.wrap-form-comment').addClass('show-guest');
                        $('[href="#tabGuest"]').trigger('click');//tabGuest
                    }
                }
            });
        } else {
            alert('Bạn chưa nhập nội dung bình luận');
        }
    });

    $(document).on('submit', '#formCommentGuest', function() {
        event.preventDefault();
        let myThis = $(this);
        //  let formData = new FormData(this);
        let formData = $(this).serialize() + '&content=' + $('#content').val();
        //  formData.append('content', $('#content').val());
        let urlRequest = $(this).data("url");
        $.ajax({
            type: "GET",
            url: urlRequest,
            data: formData,
            dataType: "JSON",
            // processData: false,
            //  contentType: false,
            success: function(response) {
                if (response.code == 200) {

                    if (response.validate) {
                        $('#loadListErrorCommentGuest').html(response.htmlErrorValidate);
                        alert('Gửi bình luận không thành công');
                    } else {
                        alert('Gửi bình luận thành công! Đang đợi admin duyệt');
                        $('#loadListComment').html(response.data);
                        $('#modal-comment').modal('hide');
                        $('#content').val('');
                        $('#loadListErrorCommentGuest').html('');
                        myThis.find('input:not([name="_token"],textarea)').val('');
                        grecaptcha.reset();
                    }
                } else {
                    alert('gửi bình luận không thành công');
                }
            }
        });
    });


    $(document).on('click', '.btn-login-social', function() {
        event.preventDefault();
        let linkhref = $(this).attr("href");
        $('#urlSocial').val(linkhref);
        $('#formCommentAuth').submit();
        //  myWindow = window.open(linkhref, "", "width=500, height=700");
    });

    $(document).on('submit', '#formRegister', function() {
        event.preventDefault();
        let formData = new FormData(this);
        let urlRequest = $(this).data("url");
        $.ajax({
            type: "POST",
            url: urlRequest,
            data: formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.code == 200) {
                    if (response.messange == 'success') {
                        // let formCommentAuth=$('#formCommentAuth');
                        //  submitFormCommentAuth('#formCommentAuth');
                        //  $('#modal-comment').modal('hide');
                        // $('.btn-send-comment-before').trigger('click');
                        callBackCommentAuth();
                    } else {
                        $('#loadListErrorRegister').html(response.htmlErrorValidate);
                        alert('Đăng ký không thành công');
                    }
                } else {
                    alert('Đăng ký không thành công');
                }
            }
        });
    });

    $(document).on('submit', '#formLogin', function() {
        event.preventDefault();
        let formData = new FormData(this);
        let urlRequest = $(this).data("url");
        $.ajax({
            type: "POST",
            url: urlRequest,
            data: formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.code == 200) {
                    if (response.messange == 'success') {
                        // let formCommentAuth=$('#formCommentAuth');
                        //  submitFormCommentAuth('#formCommentAuth');
                        //  $('#modal-comment').modal('hide');
                        // $('.btn-send-comment-before').trigger('click');
                        callBackCommentAuth();
                    } else {
                        $('#loadListErrorLogin').html(response.htmlErrorValidate);
                        alert('Đăng nhập không thành công');
                    }
                } else {
                    alert('Đăng nhập không thành công');
                }
            }
        });

    });

    $(document).on('click', '.btn-tab-login', function() {
        event.preventDefault();
        $('.wrap-form-comment').removeClass('show-guest');
        $('[href="#tabLogin"]').trigger('click');//tabGuest
    });

    function submitFormCommentAuth(element) {
        event.preventDefault();
        //  let formData = new FormData(element);
        let formData = $(element).serialize() + '&content=' + $('#content').val();
        let urlRequest = $(element).data("url");
        $.ajax({
            type: "GET",
            url: urlRequest,
            data: formData,
            dataType: "JSON",
            //   processData: false,
            //  contentType: false,
            success: function(response) {
                if (response.code == 200) {
                    $('#loadListComment').html(response.data);
                    $('#modal-comment').modal('hide');
                    $('#content').val('');
                } else {
                    alert('gửi bình luận không thành công');
                }
            }
        });
    }
});
