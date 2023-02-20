$(function() {
        $(document).on('submit', "[data-ajax='submit']", function() {
            let myThis = $(this);
            let formValues = $(this).serialize();
            let dataInput = $(this).data();
            // dataInput= {content: "#content", href: "#modalAjax", target: "modal", ajax: "submit", url: "http://127.0.0.1:8000/contact/store-ajax"}
            $.ajax({
                type: dataInput.method,
                url: dataInput.url,
                data: formValues,
                dataType: "json",
                success: function(response) {
                    if (response.code == 200) {
                        if (dataInput.content) {
                            $(dataInput.content).html(response.html);
                            myThis.find('.field').val('');
                        }
                        if (dataInput.target) {
                            switch (dataInput.target) {
                                case 'modal':
                                    $(dataInput.href).modal();
                                    break;
                                case 'alert':
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: response.html,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                default:
                                    break;
                            }
                        }
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: response.html,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                    // console.log( response.html);
                },
                error: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
            return false;
        });

} );
