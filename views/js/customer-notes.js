/*=============================================
CUSTOMER NOTES
=============================================*/

// View Customer Notes
$('.btnViewNotes').click(function(){

  var customerId = $(this).attr('customerId');
  var customerName = $(this).attr('customerName');

  $('#noteCustomerId').val(customerId);
  $('#addNoteCustomerId').val(customerId);
  $('#customerNotesName').text(customerName);

  // Hide forms
  $('#addNoteForm').hide();
  $('#editNoteForm').hide();

  // Load notes for this customer
  loadCustomerNotes(customerId);

});

// Function to load notes
function loadCustomerNotes(customerId){

  $.ajax({
    url: "ajax/customer-notes.ajax.php",
    method: "GET",
    data: {action: "getNotes", customerId: customerId},
    dataType: "json",
    success: function(notes){

      var notesHtml = '';

      if(notes && notes.length > 0){

        notes.forEach(function(note){

          // Determine icon and color based on note type
          var icon = '';
          var badgeClass = '';
          
          if(note.note_type == 'info'){
            icon = '<i class="fa fa-info-circle"></i>';
            badgeClass = 'label-success';
          }else if(note.note_type == 'reminder'){
            icon = '<i class="fa fa-bell"></i>';
            badgeClass = 'label-warning';
          }else if(note.note_type == 'warning'){
            icon = '<i class="fa fa-exclamation-triangle"></i>';
            badgeClass = 'label-danger';
          }

          notesHtml += '<tr>';
          notesHtml += '<td><span class="label '+badgeClass+'">'+icon+' '+note.note_type.toUpperCase()+'</span></td>';
          notesHtml += '<td>'+note.note_text+'</td>';
          notesHtml += '<td>'+(note.created_by_name || 'Unknown')+'</td>';
          notesHtml += '<td>'+note.created_at+'</td>';
          notesHtml += '<td>';
          
          // Edit button (admin only)
          if(typeof userProfile !== 'undefined' && userProfile == "Administrator"){
            notesHtml += '<button class="btn btn-sm btn-primary btnEditNote" noteId="'+note.id+'"><i class="fa fa-pencil"></i></button> ';
          }
          
          // Delete button (admin only)
          if(typeof userProfile !== 'undefined' && userProfile == "Administrator"){
            notesHtml += '<button class="btn btn-sm btn-danger btnDeleteNote" noteId="'+note.id+'"><i class="fa fa-trash"></i></button>';
          }
          
          notesHtml += '</td>';
          notesHtml += '</tr>';

        });

      }else{
        notesHtml = '<tr><td colspan="5" class="text-center">No notes found for this customer.</td></tr>';
      }

      $('#notesTableBody').html(notesHtml);

    },
    error: function(){
      $('#notesTableBody').html('<tr><td colspan="5" class="text-center text-danger">Error loading notes.</td></tr>');
    }
  });

}

// Show Add Note Form
$('#btnAddNote').click(function(){
  $('#addNoteForm').slideDown();
  $('#editNoteForm').hide();
  $('#addNoteText').val('');
  $('#addNoteType').val('info');
});

// Cancel Add Note
$('#btnCancelNote').click(function(){
  $('#addNoteForm').slideUp();
  $('#addNoteText').val('');
});

// Edit Note Button
$(document).on('click', '.btnEditNote', function(){

  var noteId = $(this).attr('noteId');

  // Get note details
  $.ajax({
    url: "ajax/customer-notes.ajax.php",
    method: "GET",
    data: {action: "getNote", noteId: noteId},
    dataType: "json",
    success: function(note){

      if(note){
        $('#editNoteId').val(note.id);
        $('#editNoteText').val(note.note_text);
        $('#editNoteType').val(note.note_type);
        
        $('#editNoteForm').slideDown();
        $('#addNoteForm').hide();
      }

    }
  });

});

// Cancel Edit Note
$('#btnCancelEdit').click(function(){
  $('#editNoteForm').slideUp();
  $('#editNoteText').val('');
});

// Delete Note
$(document).on('click', '.btnDeleteNote', function(){

  var noteId = $(this).attr('noteId');

  swal({
    type: "warning",
    title: "Delete Note?",
    text: "Are you sure you want to delete this note?",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete",
    cancelButtonText: "Cancel"
  }).then(function(result){

    if(result.value){
      window.location = "index.php?route=customers&idNote="+noteId;
    }

  });

});

/*=============================================
CUSTOMER WARNING ALERT IN SALES CREATION
=============================================*/

// Check for customer warnings when customer is selected in sales form
$('#selectCustomer').on('change', function(){

  var customerId = $(this).val();

  if(customerId && customerId != ''){

    // Check if customer has warnings
    $.ajax({
      url: "ajax/customer-notes.ajax.php",
      method: "GET",
      data: {action: "getWarnings", customerId: customerId},
      dataType: "json",
      success: function(warnings){

        if(warnings && warnings.length > 0){

          var warningText = '<strong>⚠️ Customer Warnings:</strong><br><br>';
          
          warnings.forEach(function(warning){
            warningText += '• ' + warning.note_text + '<br>';
          });

          swal({
            type: "warning",
            title: "Customer Alert!",
            html: warningText,
            showConfirmButton: true,
            confirmButtonText: "Proceed Anyway",
            showCancelButton: true,
            cancelButtonText: "Select Different Customer"
          }).then(function(result){

            if(!result.value){
              // User clicked cancel - clear customer selection
              $('#selectCustomer').val('').trigger('change');
            }

          });

        }

      }
    });

  }

});

