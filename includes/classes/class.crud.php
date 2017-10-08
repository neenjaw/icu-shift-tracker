<?php

/**
 * CRUD SQL Exception
 */
class CRUD_SQL_Exception extends Exception {

}

class crud
{
  private $db;

  private $tbl_staff;
  private $tbl_shift_entry;
  private $tbl_role;
  private $tbl_category;
  private $tbl_assignment;
  private $v_entries_complete;
  private $v_entries_w_staff_w_category;

  function __construct($DB_con)
  {
    $this->db = $DB_con;

    $this->tbl_staff = 'shift_tracker_tbl_staff';
    $this->tbl_shift_entry = 'shift_tracker_tbl_shift_entry';
    $this->tbl_role = 'shift_tracker_tbl_staff_role';
    $this->tbl_category = 'shift_tracker_tbl_staff_category';
    $this->tbl_assignment = 'shift_tracker_tbl_assignment';

    $this->v_entries_complete = 'v_shift_entries_w_staff_w_category_w_assignment_w_role';
    $this->v_entries_w_staff_w_category = 'v_shift_entries_w_staff_w_category';
  }

  /*
  * CRUD --
  * CREATE FUNCTIONS
  * STAFF, ROLE, CATEGORY, SHIFT
  */
  public function createStaff($f_name, $l_name, $id_category, $is_active)
  {
    try {
      $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_staff." (`id`, `first_name` , `last_name`, `category_id`, `bool_is_active`) VALUES(NULL, :fname, :lname, :cat, :act)");
      $stmt->bindparam(":fname", $f_name);
      $stmt->bindparam(":lname", $l_name);
      $stmt->bindparam(":cat", $id_category);
      $stmt->bindparam(":act", $is_active);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function createRole($r_name)
  {
    try {
      $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_role." (role) VALUES(:rn)");
      $stmt->bindparam(":rn", $r_name);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function createCategory($c_name)
  {
    try {
      $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_category." (category) VALUES(:cn)");
      $stmt->bindparam(":cn", $c_name);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function createAssignment($a_name)
  {
    try {
      $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_assignment." (assignement) VALUES(:an)");
      $stmt->bindparam(":an", $a_name);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function createMultipleShiftEntries($data) {
    return false;
  }

  public function createShiftEntry($shift_date, $staff_id, $role_id, $assignment_id, $bool_day_or_night, $bool_doubled = false, $bool_vented = false, $bool_new_admit = false, $bool_very_sick = false, $bool_code_pager = false, $bool_crrt = false, $bool_evd = false, $bool_burn = false)
  {
    try {
      $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_shift_entry." (shift_date, staff_id, role_id, assignment_id, bool_doubled, bool_vented, bool_new_admit, bool_very_sick, bool_code_pager, bool_crrt, bool_evd, bool_burn, bool_day_or_night) VALUES(:date, :sid, :rid, :aid, :bd, :bv, :bna, :bvs, :bcp, :brt, :bev, :bbu, :bdon)");

      //:date, :sid, :rid, :aid, :bd, :bv, :bna, :bvs, :bcp, :bdon
      $stmt->bindparam(":date", $shift_date);
      $stmt->bindparam(":sid", $staff_id);
      $stmt->bindparam(":rid", $role_id);
      $stmt->bindparam(":aid", $assignment_id);

      $bool_doubled = $this->booleanToInt($bool_doubled);
      $stmt->bindparam(":bd", $bool_doubled);

      $bool_vented = $this->booleanToInt($bool_vented);
      $stmt->bindparam(":bv", $bool_vented);

      $bool_new_admit = $this->booleanToInt($bool_new_admit);
      $stmt->bindparam(":bna", $bool_new_admit);

      $bool_very_sick = $this->booleanToInt($bool_very_sick);
      $stmt->bindparam(":bvs", $bool_very_sick);

      $bool_code_pager = $this->booleanToInt($bool_code_pager);
      $stmt->bindparam(":bcp", $bool_code_pager);

      $bool_crrt = $this->booleanToInt($bool_crrt);
      $stmt->bindparam(":brt", $bool_crrt);

      $bool_evd = $this->booleanToInt($bool_evd);
      $stmt->bindparam(":bev", $bool_evd);

      $bool_burn = $this->booleanToInt($bool_burn);
      $stmt->bindparam(":bbu", $bool_burn);

      $bool_day_or_night = $this->booleanToInt($bool_day_or_night);
      $stmt->bindparam(":bdon", $bool_day_or_night);

      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  private function booleanToInt($boolvalue)
  {
    if ($boolvalue) {
      return 1;
    } else {
      return 0;
    }
  }

  public function createNaShiftEntry($shift_date, $staff_id, $assignment_id, $bool_day_or_night)
  {
    try {
      $role_id = $this->db->query("SELECT id FROM ".$this->tbl_role." WHERE role='NA'");

      $this->createShiftEntry($shift_date, $staff_id, $role_id, $assignment_id, $bool_day_or_night);
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function createUcShiftEntry($shift_date, $staff_id, $assignment_id, $bool_day_or_night)
  {
    try {
      $role_id = $this->db->query("SELECT id FROM ".$this->tbl_role." WHERE role='UC'");

      $this->createShiftEntry($shift_date, $staff_id, $role_id, $assignment_id, $bool_day_or_night);
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  /*
  * CRUD --
  * READ FUNCTIONS
  * STAFF, ROLE, CATEGORY, ASSIGNMENT SHIFT ENTRY
  */

  public function getCompleteStaffObj($id) {
    $stmt = $this->db->prepare("SELECT
        {$this->tbl_staff}.id as `id`,
        {$this->tbl_staff}.last_name as `last_name`,
        {$this->tbl_staff}.first_name as `first_name`,
        {$this->tbl_staff}.category_id as `category_id`,
        {$this->tbl_category}.category as `category`
      FROM
        {$this->tbl_staff}
      LEFT JOIN
        {$this->tbl_category} on {$this->tbl_staff}.category_id = {$this->tbl_category}.id
      WHERE
        {$this->tbl_staff}.id=:sid");

    $stmt->bindparam(":sid", $id);
    $stmt->execute();

    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
    $editRow['id'] = intval($editRow['id']);
    $editRow['category_id'] = intval($editRow['category_id']);

    return $editRow;
  }

  public function getAllCompleteStaffObj($id) {
    $staff_array = array();

    $stmt = $this->db->prepare("SELECT
        {$this->tbl_staff}.id as `id`,
        {$this->tbl_staff}.last_name as `last_name`,
        {$this->tbl_staff}.first_name as `first_name`,
        {$this->tbl_staff}.category_id as `category_id`,
        {$this->tbl_category}.category as `category`
      FROM
        {$this->tbl_staff}
      LEFT JOIN
        {$this->tbl_category} on {$this->tbl_staff}.category_id = {$this->tbl_category}.id");

    $stmt->bindparam(":sid", $id);
    $stmt->execute();

    if ($stmt->rowCount()>0) {
      while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $editRow['id'] = intval($editRow['id']);
        $editRow['category_id'] = intval($editRow['category_id']);
        $staff_array[] = $editRow;
      }
    }

    return $staff_array;
  }

  public function getStaffObj($id) {
    $stmt = $this->db->prepare("SELECT
        *
      FROM
        {$this->tbl_staff}
      WHERE
        {$this->tbl_staff}.id=:sid");

    $stmt->bindparam(":sid", $id);
    $stmt->execute();
    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
    $editRow['id'] = intval($editRow['id']);
    $editRow['category_id'] = intval($editRow['category_id']);

    return $editRow;
  }

  public function getAllStaffObj() {
    $staff_array = array();

    $stmt = $this->db->prepare("SELECT
        *
      FROM
        {$this->tbl_staff}");

    $stmt->execute();

    if ($stmt->rowCount()>0) {
      while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $editRow['id'] = intval($editRow['id']);
        $editRow['category_id'] = intval($editRow['category_id']);
        $staff_array[] = $editRow;
      }
    }

    return $staff_array;
  }

  public function getStaff($category = null) {
    $staff_array = array();

    $stmt = $this->db->prepare("SELECT
        {$this->tbl_staff}.id AS `id`,
      CONCAT(
        {$this->tbl_staff}.last_name,
        \", \",
        {$this->tbl_staff}.first_name,
        \" (\",
          {$this->tbl_category}.category,
          \")\"
        ) AS `name`
      FROM
        {$this->tbl_staff}
      LEFT JOIN
        {$this->tbl_category}
      ON
        {$this->tbl_staff}.category_id = {$this->tbl_category}.id
      ".(($category !== null)? " WHERE {$this->tbl_category}.category = \"{$category}\"":"")."
      ORDER BY
        `name`");

    $stmt->execute();

    if ($stmt->rowCount()>0) {
      while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $staff_array[$editRow['id']] = $editRow['name'];
      }
    }

    return $staff_array;
  }

  public function getAllStaff()
  {
    return $this->getStaff();
  }

  public function getRnStaff()
  {
    return $this->getStaff("RN");
  }

  public function getUcStaff()
  {
    return $this->getStaff("UC");
  }

  public function getNaStaff()
  {
    return $this->getStaff("NA");
  }

  public function getStaffIdByName($f_name, $l_name)
  {
    $stmt = $this->db->prepare("SELECT id FROM ".$this->tbl_staff." WHERE last_name=:ln AND first_name:=fn");
    $stmt->bindparam(":fname", $f_name);
    $stmt->bindparam(":lname", $l_name);

    $stmt->execute();

    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);

    return $editRow;
  }

  public function getStaffById($id)
  {
    return $this->getCompleteStaffObj($id);
  }

  public function getStaffNameById($id) {
    $row = $this->getStaffById($id);
    return "{$row['last_name']}, {$row['first_name']} ({$row['category']})";
  }

  public function getAllRoleObj() {
    $role_array = array();

    $stmt = $this->db->prepare("SELECT * FROM ".$this->tbl_role."");
    $stmt->execute();

    if ($stmt->rowCount()>0) {
      while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $editRow['id'] = intval($editRow['id']);
        $role_array[] = $editRow;
      }
    }

    return $role_array;
  }

  public function getAllRoles()
  {
    $role_array = array();

    $stmt = $this->db->prepare("SELECT * FROM ".$this->tbl_role."");
    $stmt->execute();

    if ($stmt->rowCount()>0) {
      while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $role_array[$editRow['id']] = $editRow['role'];
      }
    }

    return $role_array;
  }

  public function getRoleObjById($id)
  {
    $stmt = $this->db->prepare("SELECT id, role FROM ".$this->tbl_role." WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
    return $editRow;
  }

  public function getRoleById($id)
  {
    $stmt = $this->db->prepare("SELECT role FROM ".$this->tbl_role." WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
    return $editRow;
  }

  public function getRoleNameById($id)
  {
    return ($this->getRoleById($id))["role"];
  }

  public function getAllCategoryObj() {
    $cat_array = array();

    $stmt = $this->db->prepare("SELECT * FROM ".$this->tbl_category."");
    $stmt->execute();

    if ($stmt->rowCount()>0) {
      while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $editRow['id'] = intval($editRow['id']);
        $cat_array[] = $editRow;
      }
    }

    return $cat_array;
  }

  public function getAllCateories() {
    $cat_array = array();

    $stmt = $this->db->prepare("SELECT * FROM ".$this->tbl_category."");
    $stmt->execute();

    if ($stmt->rowCount()>0) {
      while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $cat_array[$editRow['id']] = $editRow['category'];
      }
    }

    return $cat_array;
  }

  public function getCategoryById($id)
  {
    $stmt = $this->db->prepare("SELECT category FROM ".$this->tbl_category." WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
    return $editRow;
  }

  public function getAllAssignmentObj() {
    $a_array = array();

    $stmt = $this->db->prepare("SELECT * FROM ".$this->tbl_assignment." ORDER BY `id`");
    $stmt->execute();

    if ($stmt->rowCount()>0) {
      while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $editRow['id'] = intval($editRow['id']);
        $a_array[] = $editRow;
      }
    }

    return $a_array;
  }

  public function getAllAssignments()
  {
    $a_array = array();

    $stmt = $this->db->prepare("SELECT * FROM ".$this->tbl_assignment." ORDER BY `id`");
    $stmt->execute();

    if ($stmt->rowCount()>0) {
      while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $a_array[$editRow['id']] = $editRow['assignment'];
      }
    }

    return $a_array;
  }

  public function getAssignmentById($id)
  {
    $stmt = $this->db->prepare("SELECT assignment FROM ".$this->tbl_assignment." WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
    return $editRow;
  }

  public function getAssignmentNamebyID($id) {
    return ($this->getAssignmentById($id))["assignment"];
  }

  public function getShiftEntryObj($id) {
    $stmt = $this->db->prepare("SELECT * FROM " . $this->tbl_shift_entry . " WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
    $editRow['id'] = intval($editRow['id']);
    return $editRow;
  }

  public function getShiftEntry($id) {
    $stmt = $this->db->prepare("SELECT * FROM " . $this->tbl_shift_entry . " WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
    return $editRow;
  }

  public function getReadableShiftEntry($id) {
    $shift_array = $this->getShiftEntry($id);
    $readable_array = array();
    $readable_array['Id-Number'] = $shift_array['id'];
    $readable_array['Name'] = $this->getStaffNameById($shift_array['staff_id']);
    $readable_array['Date'] = $shift_array['shift_date'];
    $readable_array['Role'] = $this->getRoleNameById($shift_array['role_id']);
    $readable_array['Assignment'] = $this->getAssignmentNamebyID($shift_array['assignment_id']);
    $readable_array['NV'] = ($shift_array['bool_vented'] === '0') ? 'Yes':'No';
    $readable_array['Double'] = ($shift_array['bool_doubled'] === '1') ? 'Yes':'No';
    $readable_array['Admit'] = ($shift_array['bool_new_admit'] === '1') ? 'Yes':'No';
    $readable_array['Very-Sick'] = ($shift_array['bool_very_sick'] === '1') ? 'Yes':'No';
    $readable_array['Code-Pager'] = ($shift_array['bool_code_pager'] === '1') ? 'Yes':'No';
    $readable_array['CRRT'] = ($shift_array['bool_crrt'] === '1') ? 'Yes':'No';
    $readable_array['Burn'] = ($shift_array['bool_burn'] === '1') ? 'Yes':'No';
    $readable_array['EVD'] = ($shift_array['bool_evd'] === '1') ? 'Yes':'No';
    $readable_array['D-or-N'] = ($shift_array['bool_day_or_night'] === '1') ? 'N':'D';

    return $readable_array;
  }

  public function getShiftTableObject($days_to_print = 10, $offset_from_last_day = 0, $staff_category = 'RN')
  {
    //Likely need to make a very complex table print of shift entries here
    //
    //         | date 1 | date 2 | date 3 | Single letter denoting the most important identifier
    //  name 1 |   v    |   S    |   A    |   Cn => Clinician, Ch => Charge, O => Outreach, D => doubled, S => very sick, A => admit,
    //  name 2 |   D    |   N    |   N    |   N => Non-vented, V => vented
    //  name 3 |   -    |   -    |   D    |
    //
    //  First, determine the role id for NA / UC
    //  Then, Select the table values that are NOT NA/UC
    //  Then, left join the staff to the shift entry
    //  Then, left join the assignment to the shift entry
    //  Then, left join the role to the shift entry
    //  Then, left join the category to the shift entry
    //  Then, inner join on the results of the last x number of most recent days entered with an offset of y
    //  Then, Where the entries are RN shifts
    //  Then, order by the staff

    //query the db to get all the shifts within the specified date range
    $stmtShiftEntries = $this->db->prepare("
      SELECT
        {$this->v_entries_complete}.id AS `ID`,
        CONCAT(
          {$this->v_entries_complete}.last_name,
          \", \",
          {$this->v_entries_complete}.first_name
        ) AS `Staff`,
        {$this->v_entries_complete}.category AS `Category`,
        {$this->v_entries_complete}.staff_id AS `Staff ID`,
        {$this->v_entries_complete}.shift_date AS `Shift Date`,
        {$this->v_entries_complete}.role AS `Role`,
        {$this->v_entries_complete}.assignment AS `Assignment`,
        {$this->v_entries_complete}.bool_doubled AS `Double`,
        {$this->v_entries_complete}.bool_vented AS `Vented`,
        {$this->v_entries_complete}.bool_new_admit AS `Admit`,
        {$this->v_entries_complete}.bool_very_sick AS `Very Sick`,
        {$this->v_entries_complete}.bool_code_pager AS `Code Pager`,
        {$this->v_entries_complete}.bool_crrt AS `CRRT`,
        {$this->v_entries_complete}.bool_evd AS `EVD`,
        {$this->v_entries_complete}.bool_burn AS `Burn`,
        {$this->v_entries_complete}.bool_day_or_night AS `Day/Night`
      FROM
        {$this->v_entries_complete}
      INNER JOIN
        (
          SELECT
            DISTINCT shift_date
          FROM
            {$this->v_entries_w_staff_w_category}
          WHERE
            category = \"{$staff_category}\"
          ORDER BY
            shift_date DESC
          LIMIT
            {$days_to_print}
          OFFSET
            {$offset_from_last_day}
          ) AS t2 ON t2.shift_date = {$this->v_entries_complete}.shift_date
        WHERE
          category = \"{$staff_category}\"
        ORDER BY `Staff` ASC");

    $stmtShiftEntries->execute();

    //  Loop to:
    //    1. Create a list of all the staff
    //    2. Create a 3-dimensional array shift_array[Staff Name][Shift Date][Shift Data], not every cell will be populated
    $shift_dates_array = array();
    $staff_array = array();
    $staff_shifts_array = array();
    if ($stmtShiftEntries->rowCount()>0) {
      while ($row=$stmtShiftEntries->fetch(PDO::FETCH_ASSOC)) {
        $shift_dates_array[$row['Shift Date']] = $row['Shift Date'];

        $letter_code = '-';

        // C => Clinician, P => Prn Charge, O => Outreach, D => doubled, S => very sick, R => CRRT, B => Burn, A => admit, N => Non-vented, V => vented, F => undefined
        if (strpos($row['Role'], 'Clinician') !== false) {
          $letter_code = 'C';
        } elseif (strpos($row['Role'], 'Charge') !== false) {
          $letter_code = 'P';
        } elseif (strpos($row['Role'], 'Outreach') !== false) {
          $letter_code = 'O';
        } elseif ($row['Double'] == 1) {
          $letter_code = 'D';
        } elseif ($row['Very Sick'] == 1) {
          $letter_code = 'S';
        } elseif ($row['CRRT'] == 1) {
          $letter_code = 'R';
        } elseif ($row['Burn'] == 1) {
          $letter_code = 'B';
        } elseif ($row['Admit'] == 1) {
          $letter_code = 'A';
        } elseif ($row['Vented'] == 0) {
          $letter_code = 'N';
        } elseif ($row['Vented'] == 1) {
          $letter_code = 'V';
        } else {
          $letter_code = 'F';
        }

        if (!isset($staff_array[ $row['Staff'] ]) ) {
          $staff_array[ $row['Staff'] ] = $row['Staff ID'];
        }
        $staff_shifts_array[ $row['Staff'] ][ $row['Shift Date'] ] = array('shift_id' => $row['ID'], 'code' => $letter_code);
      }
    } else {
      die("No Shifts Entered");
    }
    //now arrange all of the dates in sequence
    ksort($shift_dates_array);

    //make a new table object
    $obj = new TableObj();
    //for each staff member....
    foreach ( $staff_array as $k => $v) {
      //make a new staff entry object
      $s = new StaffMinEntry($k, $v);

      //then for each date, enter shift data for that staff
      foreach ( $shift_dates_array as $x ) {
        //if there is a shift entry for the staff, record it
        if ( isset($staff_shifts_array[$k][$x]) ) {
          $s->shifts[] = new ShiftMinEntry($x, $staff_shifts_array[$k][$x]['shift_id'], $staff_shifts_array[$k][$x]['code']);
          //or else put in dummy entry as placeholder
        } else {
          $s->shifts[] = new ShiftMinEntry($x, -1, '-');
        }
      }

      //add the staff to the table object
      $obj->staff[] = $s;
    }

    //return the object
    return $obj;
  }

  /*
  * CRUD --
  * Update FUNCTIONS
  * STAFF, ROLE, CATEGORY, ASSIGNMENT SHIFT ENTRY
  */

  public function updateStaff($id, $f_name, $l_name, $id_category, $is_active)
  {
    try {
      $stmt = $this->db->prepare("UPDATE ".$this->tbl_staff." SET first_name=:fname, last_name=:lname, category_id=:cid, bool_is_active=:ia WHERE id=:id ");
      $stmt->bindparam(":fname", $f_name);
      $stmt->bindparam(":lname", $l_name);
      $stmt->bindparam(":cid", $id_category);
      $stmt->bindparam(":ia", $is_active);
      $stmt->bindparam(":id", $id);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateStaffToActive($id)
  {
    try {
      $stmt = $this->db->prepare("UPDATE ".$this->tbl_staff." SET bool_is_active=:bis WHERE id=:id ");
      $stmt->bindparam(":ia", 1);
      $stmt->bindparam(":id", $id);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateStaffToInactive($id)
  {
    try {
      $stmt = $this->db->prepare("UPDATE ".$this->tbl_staff." SET bool_is_active=:bis WHERE id=:id ");
      $stmt->bindparam(":ia", 0);
      $stmt->bindparam(":id", $id);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateRole($id, $r_name)
  {
    try {
      $stmt = $this->db->prepare("UPDATE ".$this->tbl_role." SET role=:rn WHERE id=:id");
      $stmt->bindparam(":rn", $r_name);
      $stmt->bindparam(":id", $id);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateCategory($id, $c_name)
  {
    try {
      $stmt = $this->db->prepare("UPDATE ".$this->tbl_category." SET category=:cn WHERE id=:id");
      $stmt->bindparam(":cn", $c_name);
      $stmt->bindparam(":id", $id);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateAssignment($id, $a_name)
  {
    try {
      $stmt = $this->db->prepare("UPDATE ".$this->tbl_assignment." SET assignement=:an WHERE id=:id");
      $stmt->bindparam(":an", $a_name);
      $stmt->bindparam(":id", $id);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateShiftEntry($id, $shift_date, $staff_id, $role_id, $assignment_id, $bool_day_or_night, $bool_doubled = false, $bool_vented = false, $bool_new_admit = false, $bool_very_sick = false, $bool_code_pager = false, $bool_crrt = false, $bool_evd = false, $bool_burn = false)
  {
    try {
      $stmt = $this->db->prepare("UPDATE ".$this->tbl_shift_entry." SET shift_date=:date, staff_id=:sid, role_id=:rid, assignment_id=:aid, bool_doubled=:bd, bool_vented=:bv, bool_new_admit=:bna, bool_very_sick=:bvs, bool_code_pager=:bcp, bool_crrt=:brt, bool_evd=:bev, bool_burn=:bbu, bool_day_or_night=:bdon,  WHERE id=:id");
      $stmt->bindparam(":date", $shift_date);
      $stmt->bindparam(":sid", $staff_id);
      $stmt->bindparam(":rid", $role_id);
      $stmt->bindparam(":aid", $assignment_id);
      $stmt->bindparam(":bd", $this->booleanToInt($bool_doubled));
      $stmt->bindparam(":bv", $this->booleanToInt($bool_vented));
      $stmt->bindparam(":bna", $this->booleanToInt($bool_new_admit));
      $stmt->bindparam(":bvs", $this->booleanToInt($bool_very_sick));
      $stmt->bindparam(":bcp", $this->booleanToInt($bool_code_pager));
      $stmt->bindparam(":brt", $this->booleanToInt($bool_crrt));
      $stmt->bindparam(":bev", $this->booleanToInt($bool_evd));
      $stmt->bindparam(":bbu", $this->booleanToInt($bool_burn));
      $stmt->bindparam(":bdon", $this->booleanToInt($bool_day_or_night));
      $stmt->bindparam(":id", $id);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateNaShiftEntry($id, $shift_date, $staff_id, $assignment_id, $bool_day_or_night)
  {
    try {
      $role_id = $this->db->query("SELECT id FROM ".$this->tbl_role." WHERE role='NA'");

      $this->updateShiftEntry($id, $shift_date, $staff_id, $role_id, $assignment_id, $bool_day_or_night);
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateUcShiftEntry($id, $shift_date, $staff_id, $assignment_id, $bool_day_or_night)
  {
    try {
      $role_id = $this->db->query("SELECT id FROM ".$this->tbl_role." WHERE role='UC'");

      $this->updateShiftEntry($id, $shift_date, $staff_id, $role_id, $assignment_id, $bool_day_or_night);
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  /*
  * CRUD --
  * Update FUNCTIONS
  * STAFF, ROLE, CATEGORY, ASSIGNMENT SHIFT ENTRY
  */

  public function deleteStaff($id)
  {
    $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_staff." WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    return true;
  }

  public function deleteRole($id)
  {
    $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_role." WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    return true;
  }

  public function deleteCategoy($id)
  {
    $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_category." WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    return true;
  }

  public function deleteAssignment($id)
  {
    $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_assignment." WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    return true;
  }

  public function deleteShiftEntry($id)
  {
    $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_shift_entry." WHERE id=:id");
    $stmt->bindparam(":id", $id);
    $stmt->execute();
    return true;
  }
}

class ShiftMinEntry
{
  public $date;
  public $id;
  public $code;

  function __construct($date, $id, $letter_code) {
    $this->date = $date;
    $this->id = $id;
    $this->code = $letter_code;
  }
}

class StaffMinEntry
{
  public $name;
  public $id;
  public $shifts;

  function __construct($name, $id) {
    $this->name = $name;
    $this->id = $id;
    $this->shifts = array();
  }
}

class TableObj
{
  public $staff;

  function __construct() {
    $this->staff = array();
  }
}

?>
