var JSFC = {
	pd: {}
}

$(function(){
	JSFC.Init();
});

JSFC.Init = function(){
	$('#payByMonth .month-action').click(function(){
		JSFC.addSalary(this);		
	});
	
	$('#payByMonth_pd .month-action').click(function(){
		console.log("hghg");
		JSFC.pd.addSalary(this);		
	});

	$('#year_selected').change(function() {
		var year = $('#year_selected').val();
		var empId = $('input[name="user_id"]').val();

		JSFC.clearAdmissableTable(year);
		JSFC.clearPayDrawnTable(year);
		JSFC.fetchStoredSalary(year, empId);
	})
	
	$('.hide-option').click(function(){
		$(this).closest('.panel').find('form').toggle();
	})

	// $('#difference_tab').click(function(){
	// 	console.log("h")
	// 	JSFC.difference();
	// })
}

// ADMISSABLE TABLE
JSFC.addSalary = function(that){
	el = $(that);
	var month = el.data('month');
	var bp = el.closest('.month-row').find('input[name="bp"]').val();
	var da = el.closest('.month-row').find('input[name="da"]').val();
	var year = $('#year_selected').val();
	var areaType = $('#payByMonth select[name="areaType"]').val();
	var empId = $('#payByMonth input[name="user_id"]').val();
	
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
        	JSFC.updateSalaryTable(data, ele);      	
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
	ele.find('.misc').html(data['misc']);
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
	var areaType = $('#payByMonth_pd select[name="areaType"]').val();
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
        	JSFC.pd.updateSalaryTable(data, ele);      	
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
	ele.find('.ca').html(data['ca']);
	ele.find('.ir').html(data['ir']);
	ele.find('.ra').html(data['ra']);
	ele.find('.wa').html(data['wa']);
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
		$(this).find('.misc').html('');
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
		$(this).find('.ca').html('');
		$(this).find('.ir').html('');
		$(this).find('.ra').html('');
		$(this).find('.wa').html('');
		$(this).find('.gross').html('');
		$(this).find('.deductions').html('');
		$(this).find('.net').html('');
	});
}

JSFC.updateDiffTable = function(data, ele){
	var diffAmt = data['admissable_pay'] - data['pay_drawn'];
	ele.find('p:first-child span').html('Rs. '+data['admissable_pay'].toFixed(2));
	ele.find('p:last-child span').html('(-)Rs. '+data['pay_drawn'].toFixed(2));
	ele.find('.card-footer span').html('Rs. '+diffAmt.toFixed(2));
}