<?php
include 'includes/pre-header.php';

if (!isset($_SESSION['user_session'])) {
  header("Location: index.php");
}
?>

<!-- Header include -->
<?php include 'includes/header.php';?>
<!-- END Header include -->

<!-- NAV bar include -->
<?php include 'includes/navbar.php'; ?>
<!-- END NAV bar include -->

<!-- Alert include -->
<?php include 'includes/alert-header.php' ?>
<!-- END Alert include -->

<div class="container">
  <div class="row">
    <div class="col-12">
      <!-- NAV include -->
      <?php include 'includes/nav-menu.php' ?>
      <!-- END NAV include -->
    </div>
  </div>
  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
      <br>
      <!-- Main Content -->
      <h2>Add a new Shift</h2>

      <form method="post" id="shift-form">
        <div class="form-group">
          <label class="control-label requiredField" for="select">Select a Staff for the shift:<span class="asteriskField">*</span></label>
          <select class="select form-control" id="select-staff" name="select">
            <option value="staff_id">Last, Name - RN</option>
          </select>
        </div>

        <div class="form-group">
          <label class="control-label requiredField" for="date">Date<span class="asteriskField">*</span></label>
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text"/>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label requiredField">Day or Night<span class="asteriskField">*</span></label>
          <div class="">
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="radio-d-or-n" id="radio-d-or-n-1" value="D"/>
                Day
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="radio-d-or-n" id="radio-d-or-n-2" value="N"/>
                Night
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label requiredField" for="select1">Role<span class="asteriskField">*</span></label>
          <select class="select form-control" id="select1" name="select1">
            <option value="First Choice">First Choice</option>
            <option value="Second Choice">Second Choice</option>
            <option value="Third Choice">Third Choice</option>
          </select>
        </div>

        <div class="form-group">
          <label class="control-label requiredField" for="select2">Pod Assignment<span class="asteriskField">*</span></label>
          <select class="select form-control" id="select2" name="select2">
            <option value="First Choice">First Choice</option>
            <option value="Second Choice">Second Choice</option>
            <option value="Third Choice">Third Choice</option>
          </select>
        </div>
        <div class="form-group">
          <label class="control-label ">Check all that apply</label>
          <div class=" ">
            <div class="checkbox"><label class="checkbox"><nput name="checkbox" type="checkbox" value="Non-vented?"/>Non-vented?</label></div>
            <div class="checkbox"><label class="checkbox"><input name="checkbox" type="checkbox" value="Doubled?"/>Doubled?</label></div>
            <div class="checkbox"><label class="checkbox"><input name="checkbox" type="checkbox" value="Admitted?"/>Admitted?</label></div>
            <div class="checkbox"><label class="checkbox"><input name="checkbox" type="checkbox" value="Code pager?"/>Code pager?</label></div>
            <div class="checkbox"><label class="checkbox"><input name="checkbox" type="checkbox" value="Very sick?"/>Very sick?</label></div>
          </div>
        </div>
        <div class="form-group">
          <div><button class="btn btn-primary " name="submit" type="submit">Submit</button></div>
        </div>
      </form>

    <!-- END Main Content -->
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
<?php include 'includes/pre-script-footer.php'; ?>
<!-- END Prefooter Include -->

<!-- Aux Scripts -->
<script>

</script>
<!-- END Aux Scripts -->

<!-- Footer Include -->
<?php include 'includes/footer.php'; ?>
<!-- END Footer Include -->
