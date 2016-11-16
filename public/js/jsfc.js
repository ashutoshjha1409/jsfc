var JSFC = {
	pd: {},
	first_six: [1, 2, 3, 4, 5, 6],
	last_six: [7, 8, 9, 10, 11, 12]
}

$(function(){
	JSFC.Init();
});

JSFC.Init = function(){
	var empId = $('input[name="user_id"]').val();
	$('#payByMonth .month-action').click(function(){
		JSFC.addSalary(this);		
	});
	
	$('#payByMonth_pd .month-action').click(function(){
		JSFC.pd.addSalary(this);		
	});

	$('#year_selected').change(function() {
		var year = $('#year_selected').val();
		JSFC.clearAdmissableTable(year);
		JSFC.clearPayDrawnTable(year);
		JSFC.clearDifferenceTable();
		JSFC.fetchStoredSalary(year, empId);
	})
	
	$('.hide-option').click(function(){
		$(this).closest('.panel').find('form').toggle();
	})

	$('#difference_tab').click(function(){
		var year = $('#year_selected').val();
		if (year != "na")
			JSFC.fetchStoredSalary(year, empId);		
	});
	// $('#payByMonth input[name="da"]').on('input', function(){
	// 	var month = $(this).data('month');
	// 	var value = $(this).val();
	// 	var exist = JSFC.first_six.includes(month);
	// 	if (exist){
	// 		$(JSFC.first_six).each(function(index) {
	// 			$('#'+this).find('input[name="da"]').val(value);
	// 		});
	// 	} else {
	// 		$(JSFC.last_six).each(function(index) {
	// 			$('#'+this).find('input[name="da"]').val(value);
	// 		});
	// 	}		
	// });

	// $('#payByMonth_pd input[name="da"]').on('input', function(){
	// 	var month = $(this).data('month');
	// 	var value = $(this).val();
	// 	var exist = JSFC.first_six.includes(month);
	// 	if (exist){
	// 		$(JSFC.first_six).each(function(index) {
	// 			$('#'+this+'_pd').find('input[name="da"]').val(value);
	// 		});
	// 	} else {
	// 		$(JSFC.last_six).each(function(index) {
	// 			$('#'+this+'_pd').find('input[name="da"]').val(value);
	// 		});
	// 	}		
	// });
}

// ADMISSABLE TABLE
JSFC.addSalary = function(that){
	el = $(that);
	var month = el.data('month');
	var bp = el.closest('.month-row').find('input[name="bp"]').val();
	var da = el.closest('.month-row').find('input[name="da"]').val();
	var year = $('#year_selected').val();
	var areaType = el.closest('.month-row').find('select[name="areaType"]').val();
	var empId = $('#payByMonth input[name="user_id"]').val();
	console.log(areaType)
	if (year == "na"){
		$('#year_selected').focus();
		$('#year_selected').tooltip('show')
		return false;
	} 

	if (!bp){
		el.closest('.month-row').find('input[name="bp"]').focus();
		return false;
	}

	if (!da){
		el.closest('.month-row').find('input[name="da"]').focus();
		return false;
	}

	$.ajax({
        url : '/salary/add',
        type : 'post',
        data : { 
			month: month,
			year: year,
			area_type: areaType,
			emp_id: empId,
			basic_pay: bp,
			da: da 
        },
        ele: el,
        headers: {
	        'X-CSRF-Token': $('input[name="_token"]').val()
	    },
        success: function(data){
        	var ele = $(el).closest('.month-row');
        	//JSFC.updateSalaryTable(data, ele);   
        	JSFC.fetchStoredSalary(year, empId);    	
        },
        error: function(data){

        },
    });
}

JSFC.updateSalaryTable = function(data, ele){	
	ele.find('input[name="bp"]').val(data['basic_pay']);
	ele.find('input[name="da"]').val(data['da']);
	ele.find('select[name="areaType"] option[value="'+data['area']+'"]').attr('selected','selected');
	ele.find('.total_pay').html(data['total_pay']);
	ele.find('.hra').html(data['hra_amt']);
	ele.find('.epf').html(data['epf_amt']);
	ele.find('.med').html(data['med']);
	ele.find('.ca').html(data['ca']);
	ele.find('.gross').html(data['gross']);
	ele.find('.deductions').html(data['deductions']);
	ele.find('.net').html(data['net_pay']);
}

// PAY DRAWN TABLE
JSFC.pd.addSalary = function(that){
	el = $(that);

	var month = el.data('month');
	var bp = el.closest('.month-row').find('input[name="bp"]').val();
	var da = el.closest('.month-row').find('input[name="da"]').val();
	var year = $('#year_selected').val();
	var areaType = el.closest('.month-row').find('select[name="areaType"]').val();
	var empId = $('input[name="user_id"]').val();
	
	if (year == "na"){
		$('#year_selected').focus();
		$('#year_selected').tooltip('show')
		return false;
	} 

	if (!bp){
		el.closest('.month-row').find('input[name="bp"]').focus();
		return false;
	}

	if (!da){
		el.closest('.month-row').find('input[name="da"]').focus();
		return false;
	}

	$.ajax({
        url : '/paydrawn/add',
        type : 'post',
        data : { 
			month: month,
			year: year,
			area_type: areaType,
			emp_id: empId,
			basic_pay: bp,
			da: da 
        },
        ele: el,
        headers: {
	        'X-CSRF-Token': $('input[name="_token"]').val()
	    },
        success: function(data){
        	var ele = $(el).closest('.month-row');
        	/*JSFC.pd.updateSalaryTable(data, ele); */
        	JSFC.fetchStoredSalary(year, empId);   	
        },
        error: function(data){

        },
    });
}

JSFC.pd.updateSalaryTable = function(data, ele){
	ele.find('input[name="bp"]').val(data['basic_pay']);
	ele.find('input[name="da"]').val(data['da']);
	ele.find('select[name="areaType"] option[value="'+data['area']+'"]').attr('selected','selected');
	ele.find('.total_pay').html(data['total_pay']);
	ele.find('.hra').html(data['hra_amt']);
	ele.find('.epf').html(data['epf_amt']);
	ele.find('.med').html(data['med']);
	ele.find('.city_alw').html(data['city_alw']);
	ele.find('.ir').html(data['ir']);
	ele.find('.ra').html(data['ra']);
	ele.find('.wa').html(data['wa']);
	ele.find('.con_alw').html(data['con_alw']);
	ele.find('.gross').html(data['gross']);
	ele.find('.deductions').html(data['deductions']);
	ele.find('.net').html(data['net_pay']);
}

JSFC.fetchStoredSalary = function(year, empId){
	$.ajax({
        url : '/salary/view',
        type : 'get',
        data : { 
			year: year,
			emp_id: empId,
        },
        headers: {
	        'X-CSRF-Token': $('input[name="_token"]').val()
	    },
        success: function(data){
        	$('#total_admissable_pay').text('Rs. '+data.netSalary);
        	$('#total_pay_drawn').text('Rs. '+data.netPayDrawn);
        	$('#net_income').text('Rs. '+data.netIncome);
        	$(data.salary).each(function( index ) {
				var el = $('tr#'+this['month']);	
				JSFC.updateSalaryTable(this, el);
			});
			$(data.pay_drawn).each(function( index ) {
				var el = $('tr#'+this['month']+'_pd');	
				JSFC.pd.updateSalaryTable(this, el);
			});
			$(data.diff).each(function( index ) {
				var el = $('#'+this['month']+'_diff');	
				JSFC.updateDiffTable(this, el);
			});
        },
        error: function(data){

        },
    });
}

JSFC.clearAdmissableTable = function(year){
	var els = $('#payByMonth table tr.month-row');
	$(els).each(function( index ) {
		var txt = $(this).find('.month').text();
		if (txt.indexOf("'") > -1){
			txt = txt.slice(0, -3);
		}
		$(this).find('.month').html(txt+"'"+year.substr(2,2));
		$(this).find('input[name="bp"]').val('');
		$(this).find('input[name="da"]').val(0);
		$(this).find('select[name="areaType"] option[value="0"]').attr('selected','selected');;
		$(this).find('.total_pay').html('');
		$(this).find('.hra').html('');
		$(this).find('.epf').html('');
		$(this).find('.med').html('');
		$(this).find('.ca').html('');
		$(this).find('.gross').html('');
		$(this).find('.deductions').html('');
		$(this).find('.net').html('');
	});
}

JSFC.clearPayDrawnTable = function(year){
	var els = $('#payByMonth_pd table tr.month-row');
	$(els).each(function( index ) {
		var txt = $(this).find('.month').text();
		if (txt.indexOf("'") > -1){
			txt = txt.slice(0, -3);
		}
		$(this).find('.month').html(txt+"'"+year.substr(2,2));
		$(this).find('input[name="bp"]').val('');
		$(this).find('input[name="da"]').val(0);
		$(this).find('select[name="areaType"] option[value="0"]').attr('selected','selected');;
		$(this).find('.total_pay').html('');
		$(this).find('.hra').html('');
		$(this).find('.epf').html('');
		$(this).find('.med').html('');
		$(this).find('.city_alw').html('');
		$(this).find('.ir').html('');
		$(this).find('.ra').html('');
		$(this).find('.wa').html('');
		$(this).find('.con_alw').html('');
		$(this).find('.gross').html('');
		$(this).find('.deductions').html('');
		$(this).find('.net').html('');
	});
}

JSFC.clearDifferenceTable =  function(){
	var els = $('#difference .col-md-3');
	$(els).each(function( index ) {
		$(this).find('.diff_ap_np span:last-child').html('N.A');
		$(this).find('.diff_ap_de span:last-child').html('N.A');
		$(this).find('.diff_pd_np span:last-child').html('N.A');
		$(this).find('.diff_pd_de span:last-child').html('N.A');
		$(this).find('.card-footer span').html('N.A');
	});
}

JSFC.updateDiffTable = function(data, ele){
	var diffAmt = data['admissable_pay'] - data['pay_drawn'];
	ele.find('.diff_ap_np span:last-child').html('Rs. '+data['admissable_pay']);
	ele.find('.diff_ap_de span:last-child').html('Rs. '+data['ap_deductions']);
	ele.find('.diff_pd_np span:last-child').html('(-)Rs. '+data['pay_drawn']);
	ele.find('.diff_pd_de span:last-child').html('Rs. '+data['pd_deductions']);
	ele.find('.card-footer span').html('Rs. '+diffAmt);
}