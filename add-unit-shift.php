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
    <div class="col-12">
      <!-- NAV include -->
      <?php include 'includes/nav-menu.php' ?>
      <!-- END NAV include -->
    </div>

    <div class="col-10">
      <h2>Add Shifts for the Unit</h2>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row justify-content-center">

      <!-- Alert Feedback -->
      <div id="shift-form-feedback" class="col-8 form-control-feedback hidden">
      </div>

    </div>
    <div class="row justify-content-center">
      <div id="msf-container" class="col-sm-12">

        <!-- Multi-step form goes here -->
        <form class="unit-shift-form">

          <?php
          //use the CRUD object to access the database and to build option lists of the staff categories
          $form_select_rn = $crud->getRnStaff();
          $form_select_na = $crud->getNaStaff();
          $form_select_uc = $crud->getUcStaff();
          ?>

          <div class="form-section form-inline mt-4 mb-4">

            <!-- DATE SELECT -->
            <div class="form-group">
              <label class="control-label requiredField mr-1" for="date">Date: </label>
              <div class="input-group mt-1">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                <input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" value="<?= date('Y-m-d') ?>" type="<?= (($detect->isMobile()) ? 'date' : 'text'); ?>" required>
              </div>

              <!-- DAY / NIGHT SELECT -->
              <div class="btn-group requiredField ml-sm-1 mt-1" data-toggle="buttons">
                <label class="btn btn-outline-primary active"><input type="radio" name="d-or-n" id="radio-d-or-n-d" value="D" autocomplete="off" checked required>Day</label>
                <label class="btn btn-outline-primary"><input type="radio" name="d-or-n" id="radio-d-or-n-n" value="N" autocomplete="off">Night</label>
              </div>
            </div>

          </div>

          <!-- TODO start adding the rest of the form elements -->
          <!-- TODO add in the bootstrap handling -->
          <!-- TODO add in the ajax to submit them all -->

          <!-- FIXME NEED TO CHANGE FROM SELECT TO TO CHOSEN - https://harvesthq.github.io/chosen/ -->

          <!-- Select Clinician/Charge -->
          <div class="form-section mt-4 mb-4">
            <!-- RN Clinician SELECT -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Who is the Clinician for the shift?<span class="asteriskField">*</span>
              </label>


              <div id="nurse-clinician" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="nc-<?= $k ?>" name="nurse-clinician" type="radio" value="<?= $k ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>

            <!-- TODO add logic which hides the charge option select if you are doing a night shift -->
            <!-- TODO add logic which hides the option of choosing the same person as the clinician -->

            <!-- RN CHARGE SELECT -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Who is the Charge for the shift?<span class="asteriskField">*</span>
              </label>

              <div id="charge-nurse" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-radio m-1">
                    <input id="cn-<?= $k ?>" name="charge-nurse" type="radio" value="<?= $k ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>


          </div>


          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- TODO assign pods to the clinician/charge -->
          <!-- </div> -->

          <div class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for A -->
            <!-- TODO add logic so that clinician and charge cant be selected -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod A<span class="asteriskField">*</span>
              </label>

              <div id="apod-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="apod-rn-<?= $k ?>" name="apod-rn[]" type="checkbox" value="<?= $k ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <div class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for B -->
            <!-- TODO add logic so that clinician and charge, pod a nurses cant be selected -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod B<span class="asteriskField">*</span>
              </label>

              <div id="bpod-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="bpod-rn-<?= $k ?>" name="bpod-rn[]" type="checkbox" value="<?= $k ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <div class="form-section mt-4 mb-4">
            <!-- Select Bedside Nurses for C -->
            <!-- TODO add logic so that clinician and charge, pod a/b nurses cant be selected -->

            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the nurses for Pod C<span class="asteriskField">*</span>
              </label>

              <div id="cpod-rn" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_rn as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="cpod-rn-<?= $k ?>" name="cpod-rn[]" type="checkbox" value="<?= $k ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- Who had non-vent -->
          <!-- </div> -->

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- Who had double -->
          <!-- </div> -->

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- Who admitted -->
          <!-- </div> -->

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- Who had very sick -->
          <!-- </div> -->

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- Who had code pager -->
          <!-- </div> -->

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- Who had crrt -->
          <!-- </div> -->

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- Who had evd -->
          <!-- </div> -->

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- Who who had burn -->
          <!-- </div> -->

          <div class="form-section mt-4 mb-4">
            <!-- Select NA's -->
            <div class="form-group">
              <label class="control-label requiredField" for="select">
                Select the NA's<span class="asteriskField">*</span>
              </label>

              <div id="na" class="staff-select-group p-0 m-0">
              <?php
              //Build Staff Select List
              foreach ($form_select_na as $k => $v):
              ?>
                <div class="inner-item list-group-item-action">
                  <label class="custom-control custom-checkbox m-1">
                    <input id="na-<?= $k ?>" name="na[]" type="checkbox" value="<?= $k ?>" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?= $v ?></span>
                  </label>
                </div>
              <?php
              endforeach;
              //END Build Staff Select List
              ?>
              </div>

            </div>
          </div>

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- TODO assign pods to the na's -->
          <!-- </div> -->

          <div class="form-section mt-4 mb-4">
          <!-- Select UC's -->
          <div class="form-group">
            <label class="control-label requiredField" for="select">
              Select the UC's<span class="asteriskField">*</span>
            </label>

            <div id="uc" class="staff-select-group p-0 m-0">
            <?php
            //Build Staff Select List
            foreach ($form_select_uc as $k => $v):
            ?>
              <div class="inner-item list-group-item-action">
                <label class="custom-control custom-checkbox m-1">
                  <input id="uc-<?= $k ?>" name="uc[]" type="checkbox" value="<?= $k ?>" class="custom-control-input">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description"><?= $v ?></span>
                </label>
              </div>
            <?php
            endforeach;
            //END Build Staff Select List
            ?>
            </div>
          </div>
          </div>

          <!-- <div class="form-section mt-4 mb-4"> -->
          <!-- TODO assign pods to the uc's -->
          <!-- </div> -->

          <div class="form-navigation m-1 text-center">
            <button type="button" class="previous btn btn-secondary">&lt; Previous</button>
            <button type="button" class="next btn btn-secondary">Next &gt;</button>
            <button type="submit" class="btn btn-secondary">Submit</button>
          </div>
        </form>

      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-8">
        <!-- Progess bar -->
        <div class="progress">
          <div id="step-progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <p id="step-x-of-y" class="text-center"></p>
      </div>
    </div>

  </div>

  <!-- Spacer for the bottom -->
  <div class="container">
    <br />
    <br />
    <br />
  </div>
  <!-- Spacer for the bottom -->

  <!-- Prefooter Include -->
  <?php include 'includes/script-include.php'; ?>
  <!-- END Prefooter Include -->

  <!-- Aux Scripts -->
  <script>
  //TODO Bind to the window, so that if user tries to back out while form is dirty, then prompts to ask
  $(function() {

    <?php if (!$detect->isMobile()): ?>
    $('#date').datepicker({
      format: "yyyy-mm-dd",
      orientation: "bottom auto",
      autoclose: true
    });
    <?php endif; ?>

    //bind the parsley.js event
    // $('#unit-shift-form')
    // .parsley({errorClass: "form-control-danger", successClass: "form-control-success"})
    // .on('field:validated', function (e) {
    //   //customize Parsely.js for Bootstrap 4
    //   if (e.validationResult.constructor!==Array) {
    //     this.$element.closest('.form-group').removeClass('has-danger').addClass('has-success');
    //   } else {
    //     this.$element.closest('.form-group').removeClass('has-success').addClass('has-danger');
    //   }
    // })
    //

    /********************************************************
     * FORM PAGINATION - CREDIT TO Parsely.js DOCUMENTATION *
     ********************************************************/
    var $sections = $('.form-section');

    function navigateTo(index) {
      // Mark the current section with the class 'current'
      $sections.removeClass('current')
               .eq(index)
               .addClass('current'); //TODO << ADD SHOW TRANSITION ANIMATION HERE BETWEEN FORMS

      // Show only the navigation buttons that make sense for the current section:
      $('.form-navigation .previous').attr("disabled", !(index > 0))
                                     .toggleClass("btn-primary", (index > 0))
                                     .toggleClass("btn-secondary", !(index > 0));

      var atTheEnd = index >= $sections.length - 1;

      $('.form-navigation .next').attr("disabled", (atTheEnd))
                                 .toggleClass("btn-primary", (!atTheEnd))
                                 .toggleClass("btn-secondary", (atTheEnd));

      $('.form-navigation [type=submit]').attr("disabled", (!atTheEnd))
                                         .toggleClass("btn-primary", (atTheEnd))
                                         .toggleClass("btn-secondary", (!atTheEnd));

      var progress = (index + 1)/$sections.length*100;
      $('#step-progress').attr('aria-valuenow', progress).css("width",(progress+"%"));
      $('#step-x-of-y').html(`Step ${index + 1} of ${$sections.length}`);
    }

    function curIndex() {
      // Return the current index by looking at which section has the class 'current'
      return $sections.index($sections.filter('.current'));
    }

    // Previous button is easy, just go back
    $('.form-navigation .previous').click(function() {
      navigateTo(curIndex() - 1);
    });

    // Next button goes forward iff current block validates
    $('.form-navigation .next').click(function() {
      $('.unit-shift-form').parsley().whenValidate({
        group: 'block-' + curIndex()
      }).done(function() {
        navigateTo(curIndex() + 1);
      });
    });

    // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
    $sections.each(function(index, section) {
      $(section).find(':input').attr('data-parsley-group', 'block-' + index);
    });
    navigateTo(0); // Start at the beginning

    /**************************
     * END -- FORM PAGINATION *
     **************************/

    //listener for click in the div to increase radio/checkbox active area
    $("div.inner-item").click(function() {
      var $elem = $(this).find("input[type='checkbox'], input[type='radio']"); // find checkbox associated
      if (!$elem.prop("disabled")) {
        $elem.prop("checked", !($elem.prop("checked"))); // toggle checked state
      }
      return false; // return false to stop click propigation
    });

    //listener which disables/clear chage nurse value depending on nurse clinician value
    var $disabledPrn = null;
    $(`#nurse-clinician div.inner-item`).click(function() {
      if ($disabledPrn !== null) {
          $disabledPrn.prop("disabled", false);
      }
      var $ncChoice = $(this).find("input[type='radio']");

      var $elem = $(`input[type='radio'][name='charge-nurse'][value='${$ncChoice.val()}']`);

      if ($elem !== null) {
        $elem.prop("checked", false);
        $elem.prop("disabled", true);
        $disabledPrn = $elem;
      }
    });

    //listener which diables/clears apod nurs depending on clinician/charge values
    // TODO Code here
    // IDEA when the form-section is made current (as in, coming in to view, get the values, disable the previously chosen ones)

    // function getNcAndCn() {} -- returns nc and cn id's
    // function getNcAndCnAndApod() { call getNcAndCn(), add id's in apod }
    // ... etc

    //listener which diables/clears bpod nurs depending on clinician/charge values
    // TODO Code here

    //listener which diables/clears cpod nurs depending on clinician/charge/apod/bpod values
    // TODO Code here

    //listener which updates shift code lists depending on all nurses selected
    // TODO Code here



  });
  </script>
  <!-- END Aux Scripts -->

  <!-- Footer Include -->
  <?php include 'includes/footer.php'; ?>
  <!-- END Footer Include -->

</body>

</html>
