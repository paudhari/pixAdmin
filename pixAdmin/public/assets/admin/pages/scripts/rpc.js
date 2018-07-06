var Rpc = function () {
		var formRpc = $('#rpc');
		var formPick = $('#pickupcentre');
    var handleRpc = function () {
    	
    	$.validator.addMethod("customemail", function(value, element) {
            return /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);
        }, "Invalid Email address");
    	$('#stateId').change(function () {
    		formRpc.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
    	$('#cityId').change(function () {
    		formRpc.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
    	formRpc.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "",
            rules: {
            	rpcName: {
                    required: true,
                    minlength: 2,
                    maxlength: 56,
                    alpha: true
                },
                rpcAddress: {
                    required: true,
                    minlength: 2,
                },
                cityId: {
                    required: true,
                },
                stateId: {
                    required: true,
                },
                pinCode: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    number: true
                },
                contactName: {
                    required: true
                },
                mobile: {
                	required: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                email: {
                    required: true,
                    customemail: true,
                    email: true,
                },
            },
            messages: {// custom messages for radio buttons and checkboxes
            	rpcName: {
                    required: 'Please enter name'
                },
                rpcAddress: {
                    required: 'Please enter address'
                },
                cityId: {
                    required: 'Please select city',
                },
                stateId: {
                    required: 'Please select state'
                },
                email: {
                    required: 'Please enter email',
                    loginRegex: "Invalid Email ID"
                },
                mobile: {
                    required: 'Please enter mobile'
                },
                contactName: {
                    required: 'Please enter contact name'
                },
                pinCode: {
                    required: "Please enter valid pin code."
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   

            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group .col-md-4 ').addClass('has-error'); // set error class to the control group
            },
            success: function (label) {
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
            submitHandler: function (formRpc) {
            	formRpc.submit();
            }
        });

        $('#rpc input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#rpc').validate().form()) {
                    $('#rpc').submit();
                }
                return false;
            }
        });

    }
    
    var handlePickup = function () {
    	
    	$('.select2', formPick).change(function () {
    		formPick.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
    	$( "select[name='holiday[typeId][]']" ).change(function () {
    		$('#pickupcentre').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
    	
    	$('.date-picker .form-control').change(function() {
    		$('#pickupcentre').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
        })
    	
    	$('#pickupcentre').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "",
            rules: {
            	pickUpName: {
                    required: true,
                    minlength: 2,
                    maxlength: 100
                },
                pickupAddress: {
                    required: true,
                    minlength: 2,
                },
                cityId: {
                    required: true,
                },
                stateId: {
                    required: true,
                },
                pinCode: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    number: true,
                },
                contactName: {
                    required: true
                },
//                contactNumber: {
//                    required: true,
//                    minlength: 10,
//                    maxlength: 12,
//                    number: true
//                },
//                'weeklyOffId[]': {
//                    required: true,
//                    minlength: 1,
//                    maxlength: 7,
//                },
//                "holiday[typeId][]" : {
//                    required: true,
//                },
//                 'holiday[date][]': {
//                     required: true,
//                 },
//                 'holiday[description][]': {
//                     required: true,
//                 },
               
            },
            messages: {// custom messages for radio buttons and checkboxes
            	pickUpName: {
                    required: 'Please enter name'
                },
                pickupAddress: {
                    required: 'Please enter address'
                },
                cityId: {
                    required: 'Please select city',
                },
                pinCode: {
                    required: 'Please enter valid pin code'
                },
                contactName: {
                    required: 'Please enter contact name'
                },
                stateId: {
                    required: 'Please select State'
                },
//                contactNumber: {
//                    required: "Please enter contact number."
//                },
//                'weeklyOffId[]': {
//                	required: "Please select atleast a day."
//                },
//                "holiday[typeId][]": {
//                	required: "Please select holiday type."
//                },
//                "holiday[date][]": {
//                	required: "Please select holiday date."
//                },
//                "holiday[description][]": {
//                	required: "Please enter description."
//                }
               
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   

            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group .col-md-4').addClass('has-error'); // set error class to the control group
                $(element)
                .closest('.no-padding').addClass('has-error');
            },
            success: function (label) {
                label.closest('.form-group .col-md-4').removeClass('has-error');
                label.closest('.no-padding').removeClass('has-error');
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

        $('#pickupcentre input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#pickupcentre').validate().form()) {
                    $('#pickupcentre').submit();
                }
                return false;
            }
        });

       
    }

    return {
        //main function to initiate the module
        init: function (str) {
        	if(str == 'rpc'){
            handleRpc(); 
        	}else{
            handlePickup();
        	}

        }

    };

}();