var ezoTaxes = function(){ 
	var txsForm = $('#taxesForm');
	var handleTaxes = function () {
		
		$('.select2').change(function () {
			txsForm.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
		$('.date-picker .form-control').change(function () {
            $('#taxesForm').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
        })
		$("#taxesForm").validate({
        	errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "",
            rules: {
                taxName: {
                    required: true,
                },
            	"stateId[]": {
                    required: true,
                },
                percentage: {
                    required: true,
                    number: true,
                    maxlength: 99,
                },
                applyingOnValue: {
                    required: true,
                },
                applyingOnProductValue: {
                    required: true,
                    number : true,
                },
                startDate: {
                    required: true,
                },
                proValOption: {
                    required: true,
                },
                masterId:{
                	required: true,
                }
            },
            messages: {
            	taxName: {
                    required: "Please enter Tax Name.",
                },
            	"stateId[]": {
                    required: "Please select State.",
                },
                percentage: {
                    required: "Please enter Tax Percentage.",
                    maxlength: "Tax should be less then 100%."
                },
                applyingOnValue: {
                    required: "Please select Apply On Value.",
                },
                applyingOnProductValue: {
                	required: "Please enter Apply On Value of Product in Category.",
                },
                startDate: {
                	required: "Please enter Setup Date.",
                },
                proValOption: {
                	required: "Please select Option.",
                },
                masterId:{
                	required: "Please select Tax.",
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   

            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group .col-lg-4 ').addClass('has-error'); // set error class to the control group
                $(element).closest('.form-group .col-lg-2 ').addClass('has-error');
                $(element).closest('.form-group .col-lg-3').addClass('has-error');
            },
            success: function (label) {
                label.closest('.form-group .col-lg-4 ').removeClass('has-error');
                label.closest('.form-group .col-lg-2 ').removeClass('has-error');
                label.closest('.form-group .col-lg-3 ').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (txsForm) {
            	txsForm.submit();
            }
        });
        $('#taxesForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#taxesForm').validate().form()) {
                    $('#taxesForm').submit();
                }
                return false;
            }
        });
        
        $('#applyingOnValue').on('change', function(){
        	
        	if($(this).val() == 'tax'){
        		$('#onOptChange').show();
        	}else{
        		$('#onOptChange').hide();
        	}
        	
        });
	}
	return {
        //main function to initiate the module
        init: function () {
        	handleTaxes();

        }

    };
}();