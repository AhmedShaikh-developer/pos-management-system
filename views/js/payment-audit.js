/*=============================================
VIEW AUDIT LOG
=============================================*/

$(document).on("click", ".btnViewAuditLog", function(){

	var saleId = $(this).attr("saleId");

	$("#modalSaleId").val(saleId);

	var datum = new FormData();
	datum.append("saleId", saleId);

	$.ajax({

		url: "ajax/payment-audit.ajax.php",
		method: "POST",
		data: datum,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(answer){

			$("#auditLogTableBody").html("");

			if(answer && answer.length > 0){

				answer.forEach(function(log){

					var oldStatusClass = "";
					var newStatusClass = "";

					if(log.old_status == "Paid"){
						oldStatusClass = "success";
					}else if(log.old_status == "Partial"){
						oldStatusClass = "warning";
					}else{
						oldStatusClass = "danger";
					}

					if(log.new_status == "Paid"){
						newStatusClass = "success";
					}else if(log.new_status == "Partial"){
						newStatusClass = "warning";
					}else{
						newStatusClass = "danger";
					}

					var datum2 = new FormData();
					datum2.append("idUser", log.changed_by);

					$.ajax({

						url: "ajax/users.ajax.php",
						method: "POST",
						data: datum2,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						async: false,
						success: function(userAnswer){

							var userName = userAnswer ? userAnswer.name : "Unknown";

							$("#auditLogTableBody").append(
								'<tr>'+
									'<td>'+log.changed_at+'</td>'+
									'<td><span class="label label-'+oldStatusClass+'">'+log.old_status+'</span></td>'+
									'<td><span class="label label-'+newStatusClass+'">'+log.new_status+'</span></td>'+
									'<td>'+userName+'</td>'+
									'<td>'+log.remarks+'</td>'+
								'</tr>'
							);

						}

					});

				});

			}else{

				$("#auditLogTableBody").html('<tr><td colspan="5" class="text-center">No audit log available</td></tr>');

			}

		}

	});

});

