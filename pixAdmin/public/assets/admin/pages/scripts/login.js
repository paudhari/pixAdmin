var Login = function () {

    var handleLogin = function () {

        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },
            messages: {
                username: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },
            submitHandler: function (form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.login-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    var handleForgetPassword = function () {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Email is required."
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   

            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $('.forget-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function () {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    }

    var handleRegister = function () {

//		function format(state) {
//            if (!state.id) return state.text; // optgroup
//            return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
//        }
//
//
//		$("#select2_sample4").select2({
//		  	placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
//            allowClear: true,
//            formatResult: format,
//            formatSelection: format,
//            escapeMarkup: function (m) {
//                return m;
//            }
//        });

        $('.date-picker .form-control').change(function () {
            $('#fosform').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
        });


        $('#stateId').change(function () {
            $('#fosform').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
        
        $.validator.addMethod("loginRegex", function(value, element) {
            return this.optional(element) || /^[a-z0-9]+$/i.test(value);
        }, "Username must contain only letters, numbers.");

        $.validator.addMethod("customemail", function(value, element) {
            return /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);
        }, "Invalid Email address");
        
//        $('#fosUserName').change(function () {
//            $('#fosform').validate().element($(this)) || (contains "^[a-zA-Z0-9]*$"); //revalidate the chosen dropdown value and show error or success message for the input
//        });
        
//        jQuery.validator.addMethod("alphanumeric", function(value, element) {
//                return this.optional(element) || (/*contains "^[a-zA-Z0-9]*$"*/);
//        });



        $('#fosform').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "",
            rules: {
                fosFirstName: {
                    required: true,
                    minlength: 2,
                    maxlength: 56,
                    alpha: true
                },
                fosLastName: {
                    required: true,
                    minlength: 2,
                    maxlength: 56,
                    alpha: true
                },
                fosEmail: {
                    required: true,
                    email: true,
                    customemail: true
                },
                fosMobile: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                fosUserName: {
                    required: true,
                    minlength: 6,
                    maxlength: 15,
                    loginRegex: true,
                },
                password: {
                    required: true
                },
                stateId: {
                    required: true
                },
                confirmPassword: {
                    equalTo: "#password"
                },
                startDate: {
                	required: true
                }
            },
            messages: {// custom messages for radio buttons and checkboxes
                fosFirstName: {
                    required: 'Please enter first name'
                },
                fosLastName: {
                    required: 'Please enter last name'
                },
                fosUserName: {
                    required: 'Please enter user name',
                    loginRegex: "Username must contain only letters, numbers"
                },
                fosMobile: {
                    required: 'Please enter mobile number'
                },
                fosEmail: {
                    required: 'Please enter email',
                    loginRegex: "Invalid Email ID"
                },
                password: {
                    required: 'Please enter password'
                },
                stateId: {
                    required: 'Please select State'
                },
                confirmPassword: {
                    required: "Please enter same password."
                },
                startDate:{
                	required: "Please select start date."
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   

            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group .col-md-6 ').addClass('has-error'); // set error class to the control group
                $(element).closest('.form-group .col-md-4 ').addClass('has-error');
            },
            success: function (label) {
                label.closest('.form-group .col-md-6 ').removeClass('has-error');
                label.closest('.form-group .col-md-4 ').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
                    error.insertAfter($('#register_tnc_error'));
                } else if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $('#fosform input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#fosform').validate().form()) {
                    $('#fosform').submit();
                }
                return false;
            }
        });

        jQuery('#register-btn').click(function () {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });

        jQuery('#register-back-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    }

    return {
        //main function to initiate the module
        init: function () {

//            handleLogin();
//            handleForgetPassword();
            handleRegister();

        }

    };

}();