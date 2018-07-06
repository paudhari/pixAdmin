var ezoOffer = function(){ 
	
	var offerForm = $('#offerform');
	var handleOffer = function () {
		$('.select2').change(function () {
			offerForm.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
		$('.date-picker .form-control').change(function() {
			offerForm.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
        })
        $('#brandId').change(function () {
			offerForm.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
        $('#image_file_upload').change(function () {
			offerForm.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
		
		offerForm.validate({
        	errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: ":hidden",
            rules: {
            	fromId: {
                    required: true,
                },
                offerName: {
                    required: true,
                },
                offerType: {
                    required: true,
                },
                offerValue: {
//                    required: true,
                    number: true,
                    maxlength: 99,
                },
                applyTo: {
                    required: true,
                },
                startDate: {
                    required: true,
                },
                endDate: {
                    required: true,
                },
                description: {
                    required: true,
                },
                tNc: {
                    required: true,
                },
                tNcDescription: {
                    required: true,
                },
                brandId:{
                	required: true,
                },
                offerOptions:{
                	required: true,
                	number: true,
                }
//                offerPic: {
//                    required: true,
////                    extension: 'jpeg|png'
//                }
            },
            messages: {
            	fromId: {
                    required: "Please select Offer From.",
                },
                offerName: {
                    required: "Please enter Offer Name.",
                },
                offerType: {
                    required: "Please select Offer Type.",
                },
                offerValue: {
//                    required: "Please enter Offer Value.",
                    maxlength: "Please enter value less than 100%"
                },
                applyTo: {
                    required: "Please select Offer Apply To",
                },
                startDate: {
                    required: "Please select Offer Start Date.",
                },
                endDate: {
                    required: "Please select Offer End Date.",
                },
                description: {
                    required: "Please enter Description.",
                },
                tNc: {
                    required: "Please accept TNC first.",
                },
                tNcDescription: {
                    required: "Please enter T&C Description.",
                },
                brandId:{
                	required: "Please select Brand.",
                },
                offerOptions:{
                	required: "Please enter Option Value.",
                }
//                offerPic: {
//                	required: "Please select offer banner.",
//                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   

            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group .col-md-4 ').addClass('has-error'); // set error class to the control group
                $(element).closest('.form-group .col-md-10 ').addClass('has-error');
                $(element).closest('.form-group .col-md-8 ').addClass('has-error');
            },
            success: function (label) {
                label.closest('.form-group .col-md-4 ').removeClass('has-error');
                label.closest('.form-group .col-md-10 ').removeClass('has-error');
                label.closest('.form-group .col-md-8 ').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                	error.insertAfter(element);
            },
            submitHandler: function (form) {
            	form.submit();
            }
        });
        $('#offerform input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#offerform').validate().form()) {
                    $('#offerform').submit();
                }
                return false;
            }
        });
	}
	var handleDropDown = function(){
		var brandDisplay = $('#dynBrand');
		var offerFrom = $('#fromId');
		var offerTyp = $('#offerType');
		var offerTypePlace = $('#dynType');
		var applyToReg = $('#applyToReg');
		var applyRegBox = $('#applyFor');
		var applyTo = $('#applyTo');
		var ofrTypBox = '<label class="col-md-4 control-label" for="offerValue">Offer Value (%) <span class="required"> * </span></label>';
		ofrTypBox = ofrTypBox +'<div class="col-md-8 " style="padding-left: 11px; padding-right: 0px;">';
		ofrTypBox = ofrTypBox +'<input type="text" name="offerValue" id="offerValue" class="form-control" max="99">';
		ofrTypBox = ofrTypBox +'</div>'; 
		var ofrTypBoxProduct = '<div class="col-md-12" style="text-align:center"> OR </div>';
		ofrTypBoxProduct = ofrTypBoxProduct +'<label class="col-md-4 control-label" for="offerValueProduct">Select Product</label>';
		ofrTypBoxProduct = ofrTypBoxProduct +'<div class="col-md-8" id="offerValProduct" style="padding-left: 11px; padding-right: 0px;">';
		ofrTypBoxProduct = ofrTypBoxProduct +'</div>'; 
		
		var brndTypBox = '<label class="col-md-2 control-label" for="brndOfferValue">Offer Value (%) <span class="required"> * </span></label>';
		brndTypBox = brndTypBox +'<div class="col-md-4 " >';
		brndTypBox = brndTypBox +'<input type="text" name="brndOfferValue" id="brndOfferValue" class="form-control">';
		brndTypBox = brndTypBox +'</div>'; 
		
		var ofrTypOption = '<label class="col-md-4 control-label" for="offerOptions">Cart Value <span class="required"> * </span></label>';
		ofrTypOption = ofrTypOption +'<div class="col-md-8 " style="padding-bottom: 2px; padding-left: 11px; padding-right: 0px;">';
		ofrTypOption = ofrTypOption +'<div class="col-md-4" style="padding-right: 0; padding-left: 0;"><select name="cartValOptns" id="cartValOptns" class="bs-select form-control">';
		ofrTypOption = ofrTypOption +'<option value="1"> Greater Than</option>';
		ofrTypOption = ofrTypOption +'<option value="2"> Less Than</option>';
		ofrTypOption = ofrTypOption +'</select> </div> <div class="col-md-8" style="padding-left: 2px; padding-right:0;">';
		ofrTypOption = ofrTypOption +'<input type="text" name="offerOptions" id="offerOptions" class="form-control">';
		ofrTypOption = ofrTypOption +'</div></div>';
		
		var minTypOption = '<label class="col-md-4 control-label" for="offerOptions">No. of Pcs <span class="required"> * </span></label>';
		minTypOption = minTypOption +'<div class="col-md-8 " style="padding-left: 11px; padding-right: 0px; padding-bottom: 2px">';
		minTypOption = minTypOption +'<input type="text" name="offerOptions" id="offerOptions" class="form-control">';
		minTypOption = minTypOption +'</div>';
		
		var minValOption = '<label class="col-md-4 control-label" for="offerValue">Free Pcs <span class="required"> * </span></label>';
		minValOption = minValOption +'<div class="col-md-8 " style="padding-bottom: 2px; padding-left: 11px; padding-right: 0px;">';
		minValOption = minValOption +'<input type="text" name="offerValue" id="offerValue" class="form-control">';
		minValOption = minValOption +'</div>';
		
		var applyCart = '<label class="col-md-2 control-label" for="applyForId">Cart Value <span class="required"> * </span></label>';
		applyCart = applyCart +'<div class="col-md-4 " style="padding-bottom:2px;">';
		applyCart = applyCart +'<input type="text" name="applyForId" id="applyForId" class="form-control">';
		applyCart = applyCart +'</div>';
		
			$(offerFrom).on('change', function() {
//				$('#dynType').html('');
//				$('#applyFor').html('');
//				$('#applyForOpt').html('');
				if($(this).val() == '17'){
					$('#box_brands').remove();
		            $('#box_product').remove();
					$.get('/offers/get-brand-list',function(data){
						brandDisplay.show();
						brandDisplay.html(data);
						$("#brandId").select2({
							placeholder: 'Select Brand',
			                minimumResultsForSearch: 10,
						});
						$("#applyTo option[value='22']").remove();
						$("#applyTo").select2({
							placeholder: 'Select Option',
						});
					});
				}else{
					
					$.get('/offers/apply-new-option',{},function(data){
						$("#applyTo").html(data);
						$("#applyTo").select2({
							placeholder: 'Select Option',
			                minimumResultsForSearch: 10,
						});
					});
					$('#applyRegBox').html('');
					$('#applyForOpt').html('');
					brandDisplay.hide();
					brandDisplay.html('');
				}
				});
			
			$(offerTyp).on('change', function() {
				console.log($(this).val());
				if($(this).val() == '18'){
					getProductList('valueOffer', 'offerValProductList', 'offerValProduct');
					offerTypePlace.html('');
					offerTypePlace.show();
					$('#applyToBoxOpt').hide();
					offerTypePlace.append(ofrTypOption);
					offerTypePlace.append(ofrTypBox);
					offerTypePlace.append(ofrTypBoxProduct);
					$("#cartValOptns").select2({
						placeholder: 'Select Option',
		                minimumResultsForSearch: 10,
					});
				}else{
					$('#applyToBoxOpt').show();
				}
				if($(this).val() == '19'){
					offerTypePlace.html('');
						offerTypePlace.html('');
						offerTypePlace.show();
						offerTypePlace.append(ofrTypBox);
					
				}
				if($(this).val() == '20'){
					offerTypePlace.html('');
					offerTypePlace.show();
					offerTypePlace.append(minTypOption);
					offerTypePlace.append(minValOption);
				}
				
				});
			
			$(applyToReg).on('change', function(){
				var str = $(this).val();
				var strTxt = $(this).find('option:selected').text();
				var placBox = $("#applyForRegion_"+strTxt);
				$('#applyFor').html('');
				if(str != 'all'){
				$.post('/offers/get-apply-region',{req : str, reqType : strTxt}, function(data){
					applyRegBox.show();
					applyRegBox.html(data);
					if(strTxt == 'State'){
						$("#applyForRegion_State").select2({
							placeholder: 'Select State',
						});
					}else{
					$("#applyForRegion_City").select2({
						placeholder: 'Select City',
		                minimumResultsForSearch: 10,
					});
				}
				});
			}
			});
			
			$(applyTo).on('change', function(){
				var str = $(this).val();
				$('#applyForOpt').html('');
				
				var otpVal = '';
				if($(this).val() == '21'){ otpVal = 'category';}
				if($(this).val() == '22'){ otpVal = 'brands';}
				if($(this).val() == '23'){ otpVal = 'product';}
//				if($(this).val() == '23'){
//					$.post('/offers/get-apply-list',{req : str}, function(data){
//						$('#applyForOpt').append(data);
//                		$("#applyForId_"+otpVal).select2({
//        					placeholder: 'Select Value'
//        				});
//					});
//				}else{
				$.post('/offers/get-apply-list',{req : str}, function(data){
					$('#applyForOpt').show();
					$('#applyForOpt').html(data);
					$("#applyForId_"+otpVal).select2({
						placeholder: 'Select Value',
		                minimumResultsForSearch: 10,
					});
				});
//				}
			});
		
	},
 getProductList = function(reqFrm, implId, placeId){
		var reqType = 'json';
		$.post('/offers/get-product-list',{reqType : reqType},function(data){
			if(data.status=='1'){
				var listAll = '<select name="offerValueProduct" id="'+implId+'" class="form-control select2">';
				listAll = listAll+'<option value=""></option>';
				$.each(data.results, function( key, value ) {
					listAll = listAll+'<option value="'+key+'">'+value+'</option>';
					});
				listAll = listAll+'</select>';
				$('#'+placeId).html(listAll);
				$("#"+implId).select2({
					placeholder: 'Select Product',
	                minimumResultsForSearch: 10,
				});
			}
			
		});
	}
	return {
        //main function to initiate the module
        init: function () {
        	handleOffer();
        	handleDropDown();

        }

    };
}();