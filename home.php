<?php
include 'includes/pre-head.php';

if (!isset($_SESSION['user_session'])) {
  header("Location: index.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
  <!-- Header include -->
  <?php include 'includes/head.php';?>
  <!-- END Header include -->

</head>
<body>
  <!-- NAV bar include -->
  <?php include 'includes/navbar.php'; ?>
  <!-- END NAV bar include -->

  <!-- Alert include -->
  <?php include 'includes/alert-header.php' ?>
  <!-- END Alert include -->

  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <!-- Nav menu include -->
        <?php include 'includes/nav-menu.php' ?>
        <!-- END nav menu include -->

      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col">
        <h2>Home</h2>
        <h4>Showing last <span id="shift-number"></span> days of shifts entered</h4>
      </div>
    </div>
    <div class="row">
      <div id="shift-table-div" class="col-md-10">
        <!-- GENERATED TABLE -->
          <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
          <span class="sr-only">Loading...</span>
        <!-- END GENERATED TABLE -->
      </div>
      <div id="shift-table-legend" class="col-md-2">
        <!-- <div class="card"> -->
        <div class="card sticky-top" style="width: 170px;">
          <div class="card-body">
            <h4 class="card-title">Legend</h4>
            <p class="card-text">Each letter represents a quick look at the entered shift.</p>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">C: Clinician</li>
            <li class="list-group-item">P: Charge</li>
            <li class="list-group-item">V: Bedside</li>
            <li class="list-group-item">O: Outreach</li>
            <li class="list-group-item">D: Doubled</li>
            <li class="list-group-item">S: Sick</li>
            <li class="list-group-item">R: CRRT</li>
            <li class="list-group-item">B: Burn</li>
            <li class="list-group-item">A: Admit</li>
            <li class="list-group-item">N: Non-vented</li>
            <li class="list-group-item">X: LPN/NA/UC</li>
            <li class="list-group-item">F: Undefined</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <br />

    <br />

    <br />
  </div>

  <!-- Bootstrap Modal -->
  <div id="shift-detail-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">

      <!-- shift details modal content -->
      <div class="modal-content" id="shift-detail-modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Shift Details:</h5>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body" id="shift-detail-text">
        </div>

        <div class="modal-footer clearfix">
          <button id='modal-edit-shift-btn' class="btn btn-secondary">Edit</button>
          <button id='modal-delete-shift-btn' class="btn btn-danger">Delete</button>
          <button id='modal-close-btn' class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /.shift-detail modal content -->

    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
  </div>

  <!-- Script include -->
  <?php include 'includes/script-include.php'; ?>
  <!-- END Script include -->

  <script id="shift-entry-template" type="text/x-handlebars-template">
    <?php include 'includes/templates/ShiftEntry.handlebars'; ?>
  </script>

  <script src="assets/build-shift-table.js"></script>

  <script>
    //TODO - create shift edit option

    var debug = true;
    var shiftTemplate = null;
    var daysToPrint = 15;
    var daysOffset = 0;
    var categoryToFetch = "*";
    var staffList = null;
    var options = {
      tableId : 'shift-table',
      tableClasses : 'table table-striped table-responsive table-hover table-sm',
      theadClasses : 'thead-inverse',
      monthClasses : 'month',
      dateClasses : 'date',
      staffDividerClasses : 'table-dark',
      locale : 'en-us'
    };

    //When document is ready
    $(function () {

      //get the first shift table
      getShiftTable(daysToPrint, daysOffset, categoryToFetch);

      $("#shift-number").html(daysToPrint);

      $("#modal-delete-shift-btn").on("click", function(){
        deleteShiftEntry($(`#shift-details-shift-id`).val());
      });

      //compile the shift template with Handlebars
      shiftTemplate = Handlebars.compile($("#shift-entry-template").html());

    });

    function getShiftTable(days, offset, category) {
      $.ajax({
        type: 'POST',
        url: 'ajax/ajax_shift_table.php',
        data: 'days='+days+'&offset='+offset+'&category='+category,
        beforeSend: function () {
        },
        success: function (response) {
          staffList = JSON.parse(response);
          if (debug) console.log("AJAX returned, staff list:");
          if (debug) console.log(staffList);
          $('#shift-table-div').html(buildShiftTable(staffList.staff,options));

          //Set click event listeners to call up modal after ajax query is returned
          $('.shift-cell a').click(function(){
            var i = $(this).parent().data('shiftId'); //get the shift id

            showShiftDetail(i);
          });
        }
      });
    }

    function showShiftDetail(id = null) {
      if (id === null) {
        return;
      }

      $.ajax({
        type: 'POST',
        url: 'ajax/ajax_shift_details.php',
        data: 'shift_id='+id+'',
        beforeSend: function () {
          $('#shift-detail-text').html();
        },
        success: function (response) {
          if (debug) { console.log(response); }
          $('#shift-detail-text').html(shiftTemplate(JSON.parse(response))); //add the result between the div tags
          $('#shift-detail-modal').modal('show');	//show the modal
        }
      });
    }

    function deleteShiftEntry(id = null) {
      if (id === null) {
        return;
      }

      $("#modal-button-delete").prop("disabled", true); //disable the button to prevent more clicks

      if (confirm("Are you sure you want to delete this shift?")) {
        $.ajax({
          type: 'POST',
          url: 'ajax/ajax_shift_delete.php',
          data: 'shift_id='+id+'',
          beforeSend: function () {
            // nada
          },
          success: function (response) {
            if (debug) { console.log(response); }

            $(`#shift-table-div`).html(`<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>`);
            getShiftTable(daysToPrint, daysOffset, categoryToFetch);

            $('#shift-detail-modal').modal('hide');

            showAlert("Shift Deleted. Showing updated table.", 'alert-success', 5000);
          }
        });
      }

      $("#modal-button-delete").prop("disabled", false); // re-enable the button
    }

    function showAlert(message = '', alertClass = 'alert-success', alertTimeout = 5000) {
      //display the alert to success
      $('#form-alert').addClass(alertClass);
      $('#form-alert p').html(`<h4>${message}</h4>`);
      $('#alert-container').collapse('show');
      $("#alert-container").focus();

      //set timeout to hide the alert in x milliseconds
      setTimeout(function(){
        $("#alert-container").collapse('hide');

        setTimeout(function(){
          $("#form-alert p").html('');
          $('#form-alert').removeClass(alertClass);
        }, 1000);
      }, alertTimeout);
    }

  </script>

  <!-- Footer include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer include -->

</body>

</html>
