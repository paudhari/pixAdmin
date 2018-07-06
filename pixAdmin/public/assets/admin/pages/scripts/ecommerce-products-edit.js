var EcommerceProductsEdit = function () {

    var handleImages = function() {

        // see http://www.plupload.com/
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
             
            browse_button : document.getElementById('tab_images_uploader_pickfiles'), // you can pass in id...
            container: document.getElementById('tab_images_uploader_container'), // ... or DOM Element itself
             
            url : "assets/plugins/plupload/examples/upload.php",
             
            filters : {
                max_file_size : '10mb',
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"},
                    {title : "Zip files", extensions : "zip"}
                ]
            },
         
            // Flash settings
            flash_swf_url : 'assets/plugins/plupload/js/Moxie.swf',
     
            // Silverlight settings
            silverlight_xap_url : 'assets/plugins/plupload/js/Moxie.xap',             
         
            init: {
                PostInit: function() {
                    $('#tab_images_uploader_filelist').html("");
         
                    $('#tab_images_uploader_uploadfiles').click(function() {
                        uploader.start();
                        return false;
                    });

                    $('#tab_images_uploader_filelist').on('click', '.added-files .remove', function(){
                        uploader.removeFile($(this).parent('.added-files').attr("id"));    
                        $(this).parent('.added-files').remove();                     
                    });
                },
         
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        $('#tab_images_uploader_filelist').append('<div class="alert alert-warning added-files" id="uploaded_file_' + file.id + '">' + file.name + '(' + plupload.formatSize(file.size) + ') <span class="status label label-info"></span>&nbsp;<a href="javascript:;" style="margin-top:-5px" class="remove pull-right btn btn-sm red"><i class="fa fa-times"></i> remove</a></div>');
                    });
                },
         
                UploadProgress: function(up, file) {
                    $('#uploaded_file_' + file.id + ' > .status').html(file.percent + '%');
                },

                FileUploaded: function(up, file, response) {
                    var response = $.parseJSON(response.response);

                    if (response.result && response.result == 'OK') {
                        var id = response.id; // uploaded file's unique name. Here you can collect uploaded file names and submit an jax request to your server side script to process the uploaded files and update the images tabke

                        $('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-success").html('<i class="fa fa-check"></i> Done'); // set successfull upload
                    } else {
                        $('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-danger").html('<i class="fa fa-warning"></i> Failed'); // set failed upload
                        Metronic.alert({type: 'danger', message: 'One of uploads failed. Please retry.', closeInSeconds: 10, icon: 'warning'});
                    }
                },
         
                Error: function(up, err) {
                    Metronic.alert({type: 'danger', message: err.message, closeInSeconds: 10, icon: 'warning'});
                }
            }
        });

        uploader.init();

    }

    var handleReviews = function () {

        var grid = new Datatable();

        grid.init({
            src: $("#datatable_reviews"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 
                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "url": "demo/ecommerce_product_reviews.php", // ajax source
                },
                "columnDefs": [{ // define columns sorting options(by default all columns are sortable extept the first checkbox column)
                    'orderable': true,
                    'targets': [0]
                }],
                "order": [
                    [0, "asc"]
                ] // set first column as a default sort by asc
            }
        });
    }

    var handleHistory = function () {

        var grid = new Datatable();

        grid.init({
            src: $("#datatable_history"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 
                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "url": "demo/ecommerce_product_history.php", // ajax source
                },
                "columnDefs": [{ // define columns sorting options(by default all columns are sortable extept the first checkbox column)
                    'orderable': true,
                    'targets': [0]
                }],
                "order": [
                    [0, "asc"]
                ] // set first column as a default sort by asc
            }
        });
    } 

    var handleProductInformation = function() {
    	function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }
    	var proForm = $('#addProductform');
    	var error = $('.alert-danger', proForm);
    	var success = $('.alert-success', proForm);
//		$("#select2_sample4").select2({
//		  	placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
//            allowClear: true,
//            formatResult: format,
//            formatSelection: format,
//            escapeMarkup: function (m) {
//                return m;
//            }
//        });
    	$('.select2').change(function () {
    		proForm.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });

//			$('#select2_sample4').change(function () {
//                $('#addProductform').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
//            });



    	proForm.validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block help-block-error', // default input error message class
	            focusInvalid: true, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	            	productName: {
	                    required: true,
                        minlength: 2,
                        maxlength : 56,
	                },
	                priceMRP : {
	                	required: true,
	                    number: true
	                },
	                packOf: {
	                    required: true,
                        minlength: 1,
                        maxlength : 3,
	                    number: true
	                },
	                priceSelling: {
	                    required: true,
	                    number: true
	                },
	                categoryId: {
	                    required: true
	                },
	                brandId: {
	                    required: true
	                },
//	                stateId: {
//	                    required: true
//	                },
	                "pickupId[]": {
	                    required: true
	                },
	                "rpcId[]": {
	                    required: true
	                },

	            },

	            messages: { // custom messages for radio buttons and checkboxes
	            	productName: {
	            		required: 'Please enter Product Name'
	            	},
	            	priceMRP: {
	            		required: 'Please enter MRP'
	            	},
	            	packOf: {
	            		required: 'Please enter valid value'
	            	},
	            	priceSelling: {
	            		required: 'Please enter eZo price'
	            	},
	            	categoryId: {
	            		required: 'Please select Category'
	            	},
	            	brandId: {
	            		required: 'Please select Brand'
	            	},
//	            	stateId: {
//	            		required: 'Please select state'
//	            	},
	            	"pickupId[]": {
	                    required: 'Please select PUC'
	                },
	                "rpcId[]": {
	                    required: 'Please select RPC'
	                },
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	            	success.hide();
                    error.show();
                    Metronic.scrollTo(error, -200);
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group .col-md-4').addClass('has-error'); // set error class to the control group
	                $(element)
                    .closest('.form-group .col-md-12').addClass('has-error');
	                var numTabs = $(element).closest('.tab-pane').attr('id');
	                var vTab = $('a[href="#' + numTabs + '"][data-toggle="tab"]');
	                vTab.parent().find('i').removeClass('fa-check').addClass('fa-times');
	                vTab.css({'color': '#a94442'});
	                
	            },

	            success: function (label) {
	                label.closest('.form-group .col-md-4').removeClass('has-error');
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
	                success.show();
                    error.hide();
	            }
	        });

			$('#addProductform input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('#addProductform').validate().form()) {
	                    $('#addProductform').submit();
	                }
	                return false;
	            }
	        });

//	        jQuery('#addProductform-btn').click(function () {
//	            jQuery('.login-form').hide();
//	            jQuery('.register-form').show();
//	        });
//
//	        jQuery('#register-back-btn').click(function () {
//	            jQuery('.login-form').show();
//	            jQuery('.register-form').hide();
//	        });
    };
    
    var initComponents = function () {
    	var navigation = $('.main-tab');
    	var total = navigation.find('li').length;
    	var active = navigation.find(".active");
    	console.log($('.main-tab .active').text());
    	var activeTab = null;
    	$('.main-tab li a[data-toggle="tab"]').on('shown', function (e) {
    	  activeTab = e.target;
    	});
    	console.log(activeTab);
//        var current = index + 1;
    }

    return {

        //main function to initiate the module
        init: function () {
//            initComponents();
            handleProductInformation();
//            handleImages();
//            handleReviews();
//            handleHistory();
        }

    };

}();