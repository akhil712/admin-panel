$(function () {
    $('body').on('click', '.formValidate', function () {
        var form = $(this).closest('form');
        form.submit();
    });

    function formValidate(form) {
        var isValid = true;

        form.find('input, select, textarea').each(function () {
            if ($(this).attr('type') === 'email' && $(this).hasClass('validate')) {
                if (!isValidEmail($(this).val())) {
                    isValid = false;
                    $(this).addClass('border-danger');
                } else {
                    $(this).removeClass('border-danger');
                }
            }
            else if ($(this).hasClass('isValidMobile') && $(this).hasClass('validate')) {
                if (!isValidMobile($(this).val())) {
                    isValid = false;
                    $(this).addClass('border-danger');
                } else {
                    $(this).removeClass('border-danger');
                }
            } 
            else if ($(this).is('select.validate')) {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('border-danger');
                } else {
                    $(this).removeClass('border-danger');
                }
            }
            else if ($(this).hasClass('validate')) {
                console.log($(this).val())
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('border-danger');
                } else {
                    $(this).removeClass('border-danger');
                }
            }
        });
        return isValid;
    }
    $('body').on('input change', 'input, select, textarea', function () {
        $(this).removeClass('border-danger');
        $(this).siblings('.error-msg').html('');
    });

    function isValidEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
    function isValidMobile(mobile) {
        var re = /^[6-9][0-9]{0,9}$/;
        return re.test(mobile);
    }

    function updateValidationMessage(inputElement, isValid) {
        var messageElement = $(inputElement).next('.mobileValidationMessage');

        if (isValid) {
            messageElement.text('Valid mobile number').css('color', 'green');
        } else {
            messageElement.text('Invalid mobile number').css('color', 'red');
        }
    }

    function handleInputChange() {
        var maxLength = 10;
        var currentVal = $(this).val();

        if (currentVal.length > maxLength) {
            $(this).val(currentVal.substring(0, maxLength));
        }

        validateMobile($(this));
    }

    function validateMobile(inputElement) {
        var mobileInput = $(inputElement).val();
        var isValid = isValidMobile(mobileInput);
        updateValidationMessage(inputElement, isValid);
    }

    $(document).ready(function () {
        $('.isValidMobile').on('input', function () {
            var currentValue = $(this).val();
            if (currentValue.length === 1 && currentValue < '6') {
                $(this).val('');
            }
            handleInputChange.call(this);
        });
    });


    $('body').on('submit', 'form', function (event) {
        var form = $(this);
        if (form.attr('id') !== "auth" && formValidate(form)) {
            event.preventDefault();
            $.ajax({
                url: form.attr('action'),
                method: form.attr("method"),
                async: true,
                data: form.serialize(),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (response) {
                    console.log(response);

                    // alert(response.msg)
                    if (response.status) {
                        // CommonMsgPopup(response.returnStatus, response.msg);
                        if (response.url) {
                            setTimeout(function () {
                                window.location.href = response.url;
                            }, 1000);
                        }
                        else {
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }
                    } else {
                        // CommonMsgPopup(ConfigStatus.Char.False.id, response.msg);
                    }
                },
                error: function (xhr) {
                    alert('Something went wrong')
                    var errors = xhr.responseJSON.errors;
                    form.find('input select textarea').removeClass('border-danger');
                    $.each(errors, function (field, errorMessage) {
                        form.find('[name="' + field + '"]').addClass('border-danger');
                        form.find('[name="' + field + '"]').siblings('.error-msg').html(errorMessage[0]);
                    });

                },
            });
        }
    });




    $('body').on('click', '.addComponent', function () {
        addComponent($(this));
    });

    function addComponent(element) {
        var pid = element.attr("pid");
        var data = element.attr("data");
        if (pid == "" || pid == undefined) {
            return false;
        }
        if (pid) {
            var len = parseInt($("#addParent_" + pid).children().length) + parseInt(1);
            $.ajax({
                url: '/add-component',
                method: "POST",
                async: true,
                data: { pid: pid, data: data, len: len },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (response) {
                    if (response.status == false) {
                        alert(response.msg);
                    } else if (response.status == true) {
                        $("#addParent_" + pid).append(response.view);
                    }
                },
                error: function (response) {
                    var msg = "";
                    $.each(response.responseJSON.errors, function (index, value) {
                        msg += value;
                        msg += "<br>";
                    });
                    if (msg != "") {
                        alert(msg);
                        // CommonMsgPopup(ConfigStatus.Char.False.id, msg);
                    }
                }
            });
        }
    }
    $('body').on('click', '.deleteRecord', function () {
        if (confirm('Are you sure you want to delete this item?')) {
            deleteRecord($(this));
        }
    });
    function deleteRecord(element) {
        if (element.attr('url') !== "") {
            $.ajax({
                url: element.attr('url'),
                method: "DELETE",
                async: true,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (response) {
                    if (response.status == false) {
                        alert(response.msg);
                    } else if (response.status == true) {
                        element.parent().parent().remove();
                    }
                },
                error: function (response) {
                    var msg = "";
                    $.each(response.responseJSON.errors, function (index, value) {
                        msg += value;
                        msg += "<br>";
                    });
                    if (msg != "") {
                        alert(msg);
                    }
                }
            });
        }
        else {
            element.parent().parent().remove();
        }
    }

    $('.multi-select-select2').select2({
        width: '100%',
        theme: 'bootstrap-5',
        closeOnSelect: false
    });
    $('.select-select2').select2({
        width: '100%',
        theme: 'bootstrap-5',
        closeOnSelect: true
    });
});