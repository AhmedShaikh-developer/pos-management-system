/*=============================================
CUSTOMER BALANCE TABLE
=============================================*/

var customerBalanceTable = $('.customerBalanceTable').DataTable({
	"order": [[ 5, "desc" ]]
});

/*=============================================
FILTER UNPAID BALANCES
=============================================*/

$("#filterUnpaid").on("ifChanged", function(){

	if($(this).prop("checked")){

		customerBalanceTable.rows().every(function(){
			var data = this.data();
			var node = this.node();
			var unpaid = parseFloat($(node).attr('data-unpaid'));

			if(unpaid == 0){
				$(node).hide();
			}
		});

	}else{

		customerBalanceTable.rows().every(function(){
			var node = this.node();
			$(node).show();
		});

	}

});

/*=============================================
LOCAL STORAGE VARIABLE 
=============================================*/

if(localStorage.getItem("captureRange3") != null){

	$("#daterange-btn3 span").html(localStorage.getItem("captureRange3"));

}else{

	$("#daterange-btn3 span").html('<i class="fa fa-calendar"></i> Date Range')

}

/*=============================================
DATES RANGE
=============================================*/

$('#daterange-btn3').daterangepicker(
  {
    ranges   : {
      'Today'       : [moment(), moment()],
      'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 days': [moment().subtract(29, 'days'), moment()],
      'this month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn3 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var initialDate = start.format('YYYY-MM-DD');

    var finalDate = end.format('YYYY-MM-DD');

    var captureRange = $("#daterange-btn3 span").html();
   
   	localStorage.setItem("captureRange3", captureRange);

   	window.location = "index.php?route=customer-balance-report&initialDate="+initialDate+"&finalDate="+finalDate;

  }

)

/*=============================================
CANCEL DATES RANGE
=============================================*/

$(".daterangepicker.opensright .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("captureRange3");
	localStorage.clear();
	window.location = "customer-balance-report";
})

