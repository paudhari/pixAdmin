var notifyMe = function(){
	var crtForm = $('#emailtemplateForm');
	var handleNotification = function () {
		
		$('#type_id').change(function () {
			crtForm.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
		
		$('#subTypeId').change(function () {
			crtForm.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
		$('#notifyType').change(function () {
			crtForm.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
		
		crtForm.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "",
            rules: {
            	type_id: {
                    required: true,
                },
                subTypeId: {
                    required: true,
                },
                subject: {
                    required: true,
                },
                "notifyType[]": {
                    required: true,
                },
//                smsContent : {
//                	required : true
//                },
//                emailContent : {
//                	required: function(textarea) {
//                        CKEDITOR.instances[textarea.id].updateElement(); // update textarea
//                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
//                        return editorcontent.length === 0;
//                      }
//                },
//                pushContent : {
//                	required: function(textarea) {
//                        CKEDITOR.instances[textarea.id].updateElement(); // update textarea
//                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
//                        return editorcontent.length === 0;
//                      }
//                },
                
            },
            messages: {// custom messages for radio buttons and checkboxes
            	type_id: {
                    required: 'Please select module.'
                },
                subTypeId: {
                    required: 'Please select event.'
                },
                subject: {
                    required: 'Please enter subject.',
                },
                "notifyType[]": {
                    required: 'Please mode of notification.'
                },
//                emailContent : {
//                	required : 'Please enter email content'
//                },
//                smsContent : {
//                	required : 'Please enter sms content'
//                },
//                pushContent : {
//                	required : 'Please enter push content'
//                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   

            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group .col-lg-6 ').addClass('has-error'); // set error class to the control group
                $(element).closest('.form-group .col-lg-10 ').addClass('has-error');
                $(element).closest('.form-group .col-lg-12').addClass('has-error');
            },
            success: function (label) {
                label.closest('.form-group .col-lg-6 ').removeClass('has-error');
                label.closest('.form-group .col-lg-10 ').removeClass('has-error');
                label.closest('.form-group .col-lg-12 ').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (crtForm) {
            	crtForm.submit();
            }
        });
		$('#emailtemplateForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#emailtemplateForm').validate().form()) {
                    $('#emailtemplateForm').submit();
                }
                return false;
            }
        });
	}
	return {
        //main function to initiate the module
        init: function () {
        	handleNotification();

        }

    };
}();