var confirmAction = false;
var myEzo = {
    updateCurrentAction: function (str) {
        confirmAction = str;
    },
    getNotifications : function () {
        $.get("/users/get-notifications", function(data, status){
            $("#orderHeaderCount").html(data.orderHeaderCount['orderHeaderCount']);
            $("#pendingHeaderCount").html(data.pendingHeaderCount['orderHeaderCount']);
            $("#packagingCount").html(data.packagingCount['packagingCount']);
            $("#dispatchCount").html(data.dispatchCount['dispatchCount']);
        });
    },
    showDetails : function (str) {
        if(str = 'packaging') {
            window.location.href = "/order/packaging-index";
        }
        else {
            window.location.href = "/order/dispatch-index";
        }
    },
    savePackageWeight : function () {
      var data = {};
      data['orderManifestId'] = $('#orderId').val();
      data['packageWeight'] = $("#package_weight").val();
      if (!$.isNumeric(data['packageWeight'])) {
    	    alert('Package Weight must be numeric format');
    	    return false;
    	}
      if(data['packageWeight'] == '0.00' || data['packageWeight'] < '0' || data['packageWeight'] == '0'){
    	  alert('Package Weight must be numeric format');
  	    return false;
      }
      
      $.ajax({
            url: '/order/save-package-weight',
            type: 'POST',
            datatype: 'json',
            data: data,
            success: function (data, status)
            {
            	$('#basic').modal('hide');
                myEzo.getPackagingList('list');
            }
        });
    },
    getExcutiveList: function (str) {
        var myData = {};
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchText'] = $('#searchText').val();
        myData['stateId'] = $('#stateId').val();
        myData['userTypeId'] = $('#userTypes').val();
        myData['columnName'] = $('#columnName').val();
        myData['sortBy'] = $('#sortBy').val();
        $.ajax({
            url: '/users/get-excutive-list',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
//            	console.log('here');
                $('#resultData').html(data);
            }
        });
    },
    getRetailerList: function (str) {
        var myData = {};
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchKey'] = $('#searchText').val();
        myData['stateId'] = $('#stateId').val();
        myData['columnName'] = $('#columnName').val();
        myData['sortBy'] = $('#sortBy').val();
        $.ajax({
            url: '/retailers/getRetailersList',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
                $('#resultData').html(data);
            }
        });
    },
    getSupRetailersList: function (str) {
        var myData = {};
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchKey'] = $('#searchText').val();
        myData['stateId'] = $('#stateId').val();
        myData['columnName'] = $('#columnName').val();
        myData['sortBy'] = $('#sortBy').val();
        $.ajax({
            url: '/super-retailer/get-retailers-list',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
                $('#resultData').html(data);
            }
        });
    },
    getRetailerDocs: function () {
        var myData = {};
        myData['retailerId'] = $('#retailId').val();
        $.ajax({
            url: '/retailers/retailer-docs/' + myData['retailerId'],
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
                $('#retailDocs').html(data);
            }
        });
    },
    updateRetailerStatus: function (retailerId, action) {
        var c = confirm('Are you sure, you want to update retailer status?');
        if (!c) {
            return false;
        }
        $('#currentPage').val(($('#currentPage').val()) - 1);
        var myData = {};
        myData['retailerId'] = retailerId;
        myData['action'] = action;
        $.ajax({
            url: '/retailers/update-retailer-status',
            type: 'POST',
            datatype: 'json',
            data: myData,
            success: function (data, status)
            {
                if (data.status == '0') {
                    myEzo.getRetailerList('search');
                } else {
                    alert(data.msg);
                }
            }
        });
    },
    searchRetailersProfile: function () {
        retailerStr = $('#retailerStr').val();
        $.post('/retailers/search-retail-data', {'retailerStr': retailerStr}, function (data) {
            $('#retailerTable').html(data);
        });
    },
    getRetailerData: function () {
        retailerStr = $('#retailerId').val();
        $.post('/retailers/search-retailer-documents', {'retailerStr': retailerStr}, function (data) {
            $('#retailerDocs').html(data);
        });
    },
    getRetailerBnkData: function () {
        retailerStr = $('#retailerId').val();
        $.post('/retailers/search-retailer-bnk', {'retailerStr': retailerStr}, function (data) {
            $('#retailerBank').html(data);
        });
    },
    sameAsAbove: function () {
        var checkStatus = $('#sameAbove').is(':checked');
        if (checkStatus) {
            $('#deliveryAddress').val($('#permanentAddress').val());
            $('#deliveryCity').val($('#permanentCity').val());
            $('#deliveryPostalCode').val($('#permanentPostalCode').val());
            $('#deliveryState').append($('<option></option>')
                    .val($("#permanentState option:selected").val())
                    .attr('selected', 'selected')
                    .html($("#permanentState option:selected").html())).trigger('liszt:updated');
            $('#s2id_deliveryState .select2-chosen').html($("#permanentState option:selected").html());
            $('#deliveryState').trigger("liszt:updated");
        } else {
            $('#deliveryAddress').val('');
            $('#deliveryCity').val('');
            $('#deliveryPostalCode').val('');
        }
    },
    getList: function (str) {

        var myData = {};
        var moduleId = $('#moduleId').val();
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchKey'] = $('#searchText').val();
        myData['columnName'] = $('#columnName').val();
        myData['sortBy'] = $('#sortBy').val();
        $.ajax({
            url: '/' + moduleId + '/get-list',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
                $('#resultData').html(data);
            }
        });
    },
    getOrdersList: function (str) {

        var myData = {};
        var moduleId = $('#moduleId').val();
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchKey'] = $('#searchText').val();
        myData['columnName'] = $('#columnName').val();
        myData['sortBy'] = $('#sortBy').val();
        $.ajax({
            url: '/' + moduleId + '/get-orders-list',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
                $('#resultData').html(data);
            }
        });
    },
    getPackagingList : function (str) {
        var myData = {};
        var moduleId = $('#moduleId').val();
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchKey'] = $('#searchText').val();
        myData['columnName'] = $('#columnName').val();
        myData['sortBy'] = $('#sortBy').val();
        $.ajax({
            url: '/' + moduleId + '/get-packaging-list',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
                $('#packagingData').html(data);
            }
        });
    },
    getDispatchList : function(str) {
        var myData = {};
        var moduleId = $('#moduleId').val();
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchKey'] = $('#searchText').val();
        myData['columnName'] = $('#columnName').val();
        myData['sortBy'] = $('#sortBy').val();
        $.ajax({
            url: '/' + moduleId + '/get-dispatched-list',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
                $('#dispatchedData').html(data);
            }
        });
    },
    getDataList: function (str) {

        var myData = {};
        var moduleId = $('#moduleId').val();
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchKey'] = $('#searchText').val();
        myData['columnName'] = $('#columnName').val();
        myData['sortBy'] = $('#sortBy').val();
        $.ajax({
            url: '/' + moduleId + '/get-list',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
                $('#resultData').html(data);
            }
        });
    },
    getPucProductList: function (str) {

        var myData = {};
        var moduleId = $('#moduleId').val();
        myData['pucId'] = $('#pucId').val();
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchKey'] = $('#searchText').val();
        $.ajax({
            url: '/' + moduleId + '/getpucproductlist',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
                $('#resultData').html(data);
            }
        });
    },
    addFos: function () {
        $.get('/users/create-users', {}, function (data) {
            $('#fosModal .modal-body').html(data);
        });
    },
    updateDocumentStatus: function (itemId, action) {
        var c = confirm('Are you sure, you want to update documents status?');
        if (!c) {
            return false;
        }
        var myData = {};
        myData['itemId'] = itemId;
        myData['operation'] = action;
        $.ajax({
            url: '/retailers/update-document-status',
            type: 'POST',
            datatype: 'json',
            data: myData,
            success: function (data, status)
            {
                if (data['status'] == '1') {
                    alert('Document status updated successfully.')
                    myEzo.getRetailerDocs();
                }
            }
        });
    },
            updateStatus : function (itemId, action, from) {
                var c = confirm('Are you sure, you want to update this status?');
                if (!c) {
                    return false;
                }
                $('#currentPage').val(($('#currentPage').val()) - 1);
                var myData = {};
                myData['itemId'] = itemId;
                myData['operation'] = action;
                $.ajax({
                    url: '/' + from + '/update-status',
                    type: 'POST',
                    datatype: 'json',
                    data: myData,
                    success: function (data, status)
                    {
                        if (data.status == '1') {
                        	if(from == 'users'){
                        		myEzo.getExcutiveList('search');
                        	}else{
                        		myEzo.getList('search');
                        	}
                        }else{
                        	alert(data.message);
                        }
                    }
                });
            },
            getRelatedProducts: function (str) {
                var proId = $('#productId').val();
                var categoryId = $('#relatedProId').val();
                var oldPro = $('#oldPro').val();
                $.post('/product/getRelatedProducts', {proId: proId, catId: categoryId, active: oldPro}, function (data) {
                    $('#relatedPro').html(data);
                });
            },
    updateRelatedProduct: function (str, stKey) {
        var proId = $('#productId').val();

        if (confirm("Are you sure, for remove this product from related list?")) {
            $.post("/product/remove-related-product", {value: str, prodId: proId}, function (data) {
                if (data.status == 1) {
                    $('#oldPro').val(data.newValue);
                    $('#pro_' + stKey).remove();
                } else {
                    alert('Somethng went wrong, please try again.');
                }

            });
        }
    },
    importProduct: function () {
        var fileData = $('#zip_file').prop('files')[0];
        var formData = new FormData();
        formData.append('file', fileData);

        $.ajax({
            url: '/product/import-product',
            type: 'POST',
            datatype: 'text',
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (data, status)
            {
                return false;
                $("#Modal").modal('toggle');
            }
        });
    },
    blockRetailer : function(str,curAct){
            $.get("/retailers/block-retailer/"+str, {}, function (data) {
                $('#feedback').modal('toggle');
                $('#feedback .modal-title').html('Please provide your remark');
                $('#feedback .modal-body').html(data);
                $('#feedbackForm').append('<input type="hidden" name="typeAction" value="'+curAct+'">');
                $('#blkbutton').show();
            });
    },
    
    blockRetailerPost : function(str){
    	var Txt = $('#remarkText').val();
    	if(Txt ==''){
    		$('#remarkText').focus();
    		alert('Please provide your remark.');
    		return false;
    	}
    	var formFata = $('#feedbackForm').serializeArray();
    	$('#feedback').modal('toggle');
        $.post("/retailers/block-retailer", {data : formFata }, function (data) {
        	if(data.status == 1){
//        		$('#feedback').modal('toggle');
        		myEzo.getRetailerList('search');
        }
        });
    },
    approveDoc : function(str, key,from){
    	var boxValue = $('#'+from+'_'+str).val();
    	if(boxValue !=''){
    		$.post("/retailers/update-document-status", { docValue : boxValue, docKey : key}, function(data){
    			if(data.status == 1){
    				alert(data.message);
    				myEzo.requestActivation();
                                myEzo.getRetailerDocs();
    			}else{
    				alert(data.message);
    			}
    			
    		});
    	}else{
    		$('#approveDoc').focus();
    	}
    },
    
    requestUpdate : function(){
    	var chkArray = [];
    	var reatiler = $('#retailId').val();
    	var checkList = $('#documentType').val();
//    	console.log(checkList); 
    	if(checkList ===null){
    		alert("Please select at least one document from Documents Type list.");
    		return false;
    	}else{
    		$.post("/retailers/request-update", { docValue : checkList, docKey : reatiler}, function(data){
    			if(data.status == 1){
    				myEzo.requestActivation();
    				alert(data.message);
    				
    			}
    			
    		});
    	}
    },
    activateRetailer : function(){
    	var reatiler = $('#retailId').val();
    	if (confirm("Are you sure, you want to activate this retailer?")) {
    	$.post("/retailers/request-activate", { reqKey : reatiler}, function(data){
    		if(data.status == 1){
//    			$('#feedbackActResponse .modal-footer').hide();
    			$('#feedbackActResponse').modal('toggle');
                $('#feedbackActResponse .modal-title').html('Successfully Activated');
                $('#feedbackActResponse .modal-footer').hide();
                $('#feedbackActResponse .modal-body').html('Retailer activated.');																																																																																																																																																																					
    		}else{
    			myEzo.getForceActivation();
//    			$('#feedback').modal('toggle');
//                $('#feedback .modal-title').html('Message');
//                $('#feedback .modal-body').html(data.message);
    		}
    	});
    	}
    },
    requestActivation : function(){
    	var retailer = $('#retailId').val();
    	$.post('/retailers/check-activation-status',{reqKey : retailer}, function(data){
    		$('#activationPro').html(data);
    		 
    	});
    },
    
    resetFOS : function(str){
    	if (confirm("Are you sure, you want to reset password?")) {
    		$.post('/users/reset-password',{reqKey : str}, function(data){
    		$('#fosModal').modal('toggle');
            $('#fosModal .modal-title').html('Reset Password');
            $('#fosModal .modal-body').html(data.message);
    	});
    	}
    },
    getForceActivation : function(){
    	var retailer = $('#retailId').val();
    	$.get('/retailers/activation-feedback/'+retailer,{}, function(data){
    		$('#feedbackActivation').modal('toggle');
            $('#feedbackActivation .modal-title').html('Activation remark');
            $('#feedbackActivation .modal-body').html(data);	
    	});
    },
    updateForceActivation : function(){
    	var formFata = $('#feedbackActivationForm').serializeArray();
    	$.post('/retailers/activation-feedback',{data : formFata}, function(data){
            $('#feedbackActivation .modal-title').html('Retailer Activation');
            $('#feedbackActivation .modal-body').html(data.message);
            $('#rldPage').html('<button data-dismiss="modal" class="btn default" type="button" onClick="window.location.reload()">Close</button>');
    	});
    },
    
    manageSorting : function(modName, fieldName, sortBy){
    	$('#columnName').val(fieldName);
    	$('#sortBy').val(sortBy);
    	if(modName == 'usersList'){
    		myEzo.getExcutiveList('search');
    	}
    	if(modName == 'retailerList'){
    		myEzo.getRetailerList('search');
    	}
    	if(modName == 'getList'){
    		myEzo.getList('search');
    	}
    	if(modName == 'dataList'){
    		myEzo.getDataList('search');
    	}
    	if(modName == 'attendanceList'){
    		myEzo.getAttendanceList('search');
    	}
        if(modName == 'getSupRetailersList'){
    		myEzo.getSupRetailersList('search');
    	}
        if(modName == 'getOrdersList'){
    		myEzo.getOrdersList('search');
    	}
    	
    },
    
    getAttendanceList: function (str) {
        var myData = {};
        myData['currentPage'] = 0;
        if (str != 'search') {
            myData['currentPage'] = $('#currentPage').val();
        }
        myData['searchText'] = $('#searchText').val();
        myData['currentDate'] = $('#currentDate').val();
        myData['columnName'] = $('#columnName').val();
        myData['sortBy'] = $('#sortBy').val();
        $.ajax({
            url: '/users/get-attendance-response',
            type: 'POST',
            datatype: 'html',
            data: myData,
            success: function (data, status)
            {
//            	console.log('here');
                $('#resultData').html(data);
            }
        });
    },
    getRetailerOrderData : function(str){
    	 var myData = {};
    	 myData['retailerId'] = $('#retailerId').val();
         myData['currentPage'] = 0;
         if (str != 'search') {
             myData['currentPage'] = $('#currentPage').val();
         }
         myData['searchText'] = $('#searchText').val();
         myData['currentDate'] = $('#currentDate').val();
         $.ajax({
             url: '/order/get-order-by-retailer',
             type: 'POST',
             datatype: 'html',
             data: myData,
             success: function (data, status)
             {
//             	console.log('here');
                 $('#resultData').html(data);
             }
         });
    },
    getSuperNotifications : function () {
        $.get("/super-retailer/get-notifications", function(data, status){
            $("#orderHeaderCount").html(data.orderHeaderCount['orderHeaderCount']);
            $("#pendingHeaderCount").html(data.pendingHeaderCount['orderHeaderCount']);
            $("#packagingCount").html(data.packagingCount['packagingCount']);
            $("#dispatchCount").html(data.dispatchCount['dispatchCount']);
        });
    },
};
