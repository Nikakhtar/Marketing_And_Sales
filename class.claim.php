<?php
require_once ("classes/class.invoice.php");
/**
 *
 */
class Claim
{
  private $id;
  private $invoice;
  private $manager;
  private $manager_Dsp;
  private $submitDate;
  private $latestReviewDate;
  private $reviewer;
  private $reviewer_Dsp;
  private $state;
  private $state_Dsp;
  private $startDelay;
  private $totalDelay;
  private $totalSpentTime;
  private $expectedDate;
  private $possibleDate;
  private $amount;
  private $deadline;
  private $holding;
  private $document;
  private $description;
  private $delaySupport;
  private $priority;
  private $invoiceObject;
  private $current_holding_Deadline;
  private $db = "3369816905d579ef34e2094076840766";
  private $sqlQuery;
  /////////////////
  public function __construct($id = NULL, $manager = NULL, $submitDate = NULL, $expectedDate = NULL, $possibleDate = NULL, $amount = NULL, $deadline = NULL, $startDelay = NULL, $description = NULL, $delaySupport = NULL, $priority = NULL, $invoiceObject)
  {
    $g = new G();
    $g->loadClass('pmFunctions');
    if ($id == NULL) {
      $this->set_invoiceObject($invoiceObject);
      $this->invoice = $this->invoiceObject->get_id();
      $this->manager = $manager;
      $this->manager_Dsp = NULL;
      $this->submitDate = $submitDate;
      $this->latestReviewDate = NULL;
      $this->reviewer = NULL;
      $this->reviewer_Dsp = NULL;
      $this->state = 1;
      $this->state_Dsp = NULL;
      $this->startDelay = $startDelay;
      $this->totalDelay = 0;
      $this->totalSpentTime = 0;
      $this->expectedDate = $expectedDate;
      $this->possibleDate = $possibleDate;
      $this->amount = $amount;
      $this->holding = NULL;
      $this->document = NULL;
      $this->current_holding_Deadline = NULL;
      $this->description = $description;
      $this->deadline = $deadline;
      $this->delaySupport = $delaySupport;
      $this->priority = $priority;
      $this->id = $this->insert_claim();
      if ($this->id != NULL) {
        $this->get_invoiceObject()->update_state(4);
      }
    }
    elseif ($id != NULL) {
      $this->id = $id;
    }
  }
  ////////////////////
  private function insert_claim()
  {
    $this->sqlQuery = "INSERT INTO `claim`(`Id`, `Invoice`, `Manager`, `Submit_Date`, `Latest_Review_Date`, `Reviewer`, `State`, `Start_Delay`, `Total_Delay`, `Total_Spent_Time`, `Expected_Date`, `Possible_Date`, `Amount`, `Description`, `Priority`, `Deadline`, `Delay_Support`) VALUES(NULL, '$this->invoice', '$this->manager', '$this->submitDate', '$this->latestReviewDate', '$this->reviewer', '$this->state', '$this->startDelay', '$this->totalDelay', '$this->totalSpentTime', '$this->expectedDate', '$this->possibleDate', '$this->amount', '$this->description', '$this->priority', '$this->deadline', '$this->delaySupport')";
    executeQuery($this->sqlQuery, $this->db);
    $result = executeQuery("SELECT LAST_INSERT_ID()", $this->db);
    return $result[1]['LAST_INSERT_ID()'];
  }
  ////////////////////
  public function insert_claim_holding($owner, $description, $submitDate, $deadline, $spentTime, $result, $passTo)
  {
    $this->sqlQuery = "INSERT INTO `claim_holding`(`Id`, `Claim`, `Owner`, `Description`, `Submit_Date`, `Deadline`, `Delay`, `Spent_Time`, `Result`, `Pass_To`) VALUES(NULL, '$this->id', '$owner', '$description', '$submitDate', '$deadline', NULL, '$spentTime', '$result', '$passTo')";
    executeQuery($this->sqlQuery, $this->db);
    if ($result == 1) {
      $this->update_state(1);
    }
    elseif ($result == 2) {
      $this->get_invoiceObject()->update_state(5);
    }
    elseif ($result == 3) {
      $this->get_invoiceObject()->update_state(6);
    }
    //elseif ($result == 4) {
      //$this->update_state(4);
    //}
    $this->current_holding_Deadline = $deadline;
  }
  ////////////////////
  public function insert_claim_document($archivist, $depositDate, $depositAmount, $bank, $valueAdded, $insuranceCost, $tax, $depositCost, $documentLink)
  {
    $this->sqlQuery = "INSERT INTO `claim_document`(`Id`, `Claim`, `Archivist`, `Deposit_Date`, `Deposit_Amount`, `Bank`, `Value_Added`, `Insurance_Cost`, `Tax`, `Deposit_Cost`, `Document_Link`) VALUES(NULL, '$this->id', '$archivist', '$depositDate', '$depositAmount', '$bank', '$valueAdded', '$insuranceCost', '$tax', '$depositCost', '$documentLink')";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////
  public function set_invoiceObject($invoiceObject)
  {
    $this->invoiceObject = $invoiceObject;
  }
  //////////////////////
  public function get_id()
  {
    return $this->id;
  }
  ////////////////////////
  public function get_invoice()
  {
    $this->sqlQuery = "SELECT `claim`.`Invoice` AS Claim_invoice FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->invoice = $result[1]['Claim_invoice'];
    return $this->invoice;
  }
  ////////////////////////
  public function get_invoiceObject()
  {
    $this->invoiceObject = new Invoice($this->get_invoice());
    $this->invoiceObject = unserialize(serialize ($this->invoiceObject));
    $this->invoiceObject->db = $this->db;
    return $this->invoiceObject;
  }
  ////////////////////////
  public function get_manager_Dsp()
  {
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Claim_manager` FROM `claim` INNER JOIN `bitnami_pm`.`users` ON `Manager` = `USR_UID` WHERE `claim`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager_Dsp = $result[1]['Claim_manager'];
    return $this->manager_Dsp;
  }
    ////////////////////////
  public function get_manager()
  {
    $this->sqlQuery = "SELECT `claim`.`Manager` AS Claim_manager FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager = $result[1]['Claim_manager'];
    return $this->manager;
  }
  /////////////////////////
  public function get_submitDate()
  {
    $this->sqlQuery = "SELECT `claim`.`Submit_Date` AS Claim_submitDate FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->submitDate = $result[1]['Claim_submitDate'];
    return $this->submitDate;
  }
  ////////////////////////
  public function get_latestReviewDate()
  {
    $this->sqlQuery = "SELECT `claim`.`Latest_Review_Date` AS Claim_latestReviewDate FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->latestReviewDate = $result[1]['Claim_latestReviewDate'];
    return $this->latestReviewDate;
  }
  //////////////////////////
  public function get_reviewer()
  {
    $this->sqlQuery = "SELECT `claim`.`Reviewer` AS Claim_reviewer FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer = $result[1]['Claim_reviewer'];
    return $this->reviewer;
  }
  //////////////////////////
  public function get_reviewer_Dsp()
  {
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Claim_reviewer` FROM `claim` INNER JOIN `bitnami_pm`.`users` ON `Reviewer` = `USR_UID` WHERE `claim`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer_Dsp = $result[1]['Claim_reviewer'];
    return $this->reviewer_Dsp;
  }
  //////////////////////////
  public function get_state()
  {
    $this->sqlQuery = "SELECT `claim`.`State` AS Claim_state FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state = $result[1]['Claim_state'];
    return $this->state;
  }
  ////////////////////////
  public function get_state_Dsp()
  {
    $this->sqlQuery = "SELECT `state`.`State` AS Claim_state FROM `state` INNER JOIN `claim` ON `claim`.`State` = `state`.`Id` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state_Dsp = $result[1]['Claim_state'];
    return $this->state_Dsp;
  }
  ////////////////////////
  public function get_startDelay()
  {
    $this->sqlQuery = "SELECT `claim`.`Start_Delay` AS Claim_startDelay FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->startDelay = $result[1]['Claim_startDelay'];
    return $this->startDelay;
  }
  ////////////////////////
  public function get_description()
  {
    $this->sqlQuery = "SELECT `claim`.`Description` AS Claim_description FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->description = $result[1]['Claim_description'];
    return $this->description;
  }
  ////////////////////////
  public function get_deadline()
  {
    $this->sqlQuery = "SELECT `claim`.`Deadline` AS Claim_deadline FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->deadline = $result[1]['Claim_deadline'];
    return $this->deadline;
  }
  ////////////////////////
  public function get_delaySupport()
  {
    $this->sqlQuery = "SELECT `claim`.`Delay_Support` AS Claim_delaySupport FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->delaySupport = $result[1]['Claim_delaySupport'];
    return $this->delaySupport;
  }
  ////////////////////////
  public function get_priority()
  {
    $this->sqlQuery = "SELECT `claim`.`Priority` AS Claim_priority FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->priority = $result[1]['Claim_priority'];
    return $this->priority;
  }
  ////////////////////////
  public function get_totalDelay()
  {
    $this->sqlQuery = "SELECT `claim`.`Total_Delay` AS Claim_totalDelay FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->totalDelay = $result[1]['Claim_totalDelay'];
    return $this->totalDelay;
  }
  ////////////////////////////////////////////////
  public function get_totalSpentTime()
  {
    $this->sqlQuery = "SELECT `claim`.`Total_Spent_Time` AS Claim_totalSpentTime FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->totalSpentTime = $result[1]['Claim_totalSpentTime'];
    return $this->totalSpentTime;
  }
  ////////////////////////////////////////////////
  public function get_expectedDate()
  {
    $this->sqlQuery = "SELECT `claim`.`Expected_Date` AS Claim_expectedDate FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->expectedDate = $result[1]['Claim_expectedDate'];
    return $this->expectedDate;
  }
  ////////////////////////////////////////////////
  public function get_possibleDate()
  {
    $this->sqlQuery = "SELECT `claim`.`Possible_Date` AS Claim_possibleDate FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->possibleDate = $result[1]['Claim_possibleDate'];
    return $this->possibleDate;
  }
  ////////////////////////////////////////////////
  public function get_amount()
  {
    $this->sqlQuery = "SELECT `claim`.`Amount` AS Claim_amount FROM `claim` WHERE `claim`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->amount = $result[1]['Claim_amount'];
    return $this->amount;
  }
  ////////////////////////////////////////////////
  public function get_holding($lable1 = NULL, $lable2 = NULL, $lable3 = NULL, $lable4 = NULL, $lable5 = NULL, $lable6 = NULL, $lable7 = NULL, $lable8 = NULL, $lable9 = NULL, $lable10 = NULL)
  {
    $this->sqlQuery = "SELECT `claim_holding`.`Id` AS '".$lable1."', `claim_holding`.`Claim` AS '".$lable2."', CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS '".$lable3."', `claim_holding`.`Description` AS '".$lable4."', `claim_holding`.`Submit_Date` AS '".$lable5."', `claim_holding`.`Deadline` AS '".$lable6."', `claim_holding`.`Delay` AS '".$lable7."', `claim_holding`.`Spent_Time` AS '".$lable8."', `holding_result`.`Result` AS '".$lable9."', `claim_holding`.`Pass_To` AS '".$lable10."' FROM `claim_holding` LEFT JOIN `holding_result` ON `claim_holding`.`Result` = `holding_result`.`Id` INNER JOIN `bitnami_pm`.`users` ON `Owner` = `USR_UID` WHERE `claim_holding`.`Claim` = '".$this->id."'";
    $this->holding = executeQuery($this->sqlQuery, $this->db);
    return $this->holding;
  }
  ////////////////////////////////////////////////
  public function get_document($lable1 = NULL, $lable2 = NULL, $lable3 = NULL, $lable4 = NULL, $lable5 = NULL, $lable6 = NULL, $lable7 = NULL, $lable8 = NULL, $lable9 = NULL, $lable10 = NULL, $lable11 = NULL)
  {
    $this->sqlQuery = "SELECT `claim_document`.`Id` AS '".$lable1."', `claim_document`.`Claim` AS '".$lable2."', CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS '".$lable3."', `claim_document`.`Deposit_Date` AS '".$lable4."', `claim_document`.`Deposit_Amount` AS '".$lable5."', `claim_document`.`Bank` AS '".$lable6."', `claim_document`.`Value_Added` AS '".$lable7."', `claim_document`.`Insurance_Cost` AS '".$lable8."', `claim_document`.`Tax` AS '".$lable9."', `claim_document`.`Deposit_Cost` AS '".$lable10."', `claim_document`.`Document_Link` AS '".$lable11."' FROM `claim_document` INNER JOIN `bitnami_pm`.`users` ON `Archivist` = `USR_UID` WHERE `claim_document`.`Claim` = '".$this->id."'";
    $this->document = executeQuery($this->sqlQuery, $this->db);
    return $this->document;
  }
  //////////////////////
  public function get_current_holding_Deadline()
  {
    //$this->sqlQuery = "SELECT `Deadline` FROM(SELECT * FROM `claim_holding` WHERE `claim_holding`.`claim` = '".$this->id."') WHERE `Id` = (SELECT MAX(id) FROM TABLE)";
    //$this->invoice = executeQuery($this->sqlQuery, $this->db);
    //return $this->current_holding_Deadline;
  }
  ////////////////////////
  ////////////////////////
  ///////////////////////
  //////////////////////
  public function update_id($id)
  {
    $this->id = $id;
    $this->sqlQuery = "UPDATE `claim` SET `Id` = '".$this->id."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_manager($manager)
  {
    $this->manager = $manager;
    $this->sqlQuery = "UPDATE `claim` SET `Manager` = '".$this->manager."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  /////////////////////////
  public function update_invoice($invoice)
  {
    $this->invoice = $invoice;
    $this->sqlQuery = "UPDATE `claim` SET `invoice` = '".$this->invoice."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_submitDate($submitDate)
  {
    $this->submitDate = $submitDate;
    $this->sqlQuery = "UPDATE `claim` SET `Submit_Date` = '".$this->submitDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_latestReviewDate($latestReviewDate)
  {
    $this->latestReviewDate = $latestReviewDate;
    $this->sqlQuery = "UPDATE `claim` SET `Latest_Review_Date` = '".$this->latestReviewDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_reviewer($reviewer)
  {
    $this->reviewer = $reviewer;
    $this->sqlQuery = "UPDATE `claim` SET `Reviewer` = '".$this->reviewer."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_state($state)
  {
    $this->state = $state;
    $this->sqlQuery = "UPDATE `claim` SET `State` = '".$this->state."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
    if ($state == 1) {
      $this->get_invoiceObject()->update_state(4);
    }
    elseif ($state == 2) {
      $this->get_invoiceObject()->update_state(8);
    }
    elseif ($state == 3) {
      $this->get_invoiceObject()->update_state(9);
    }
    elseif ($state == 4) {
      $this->get_invoiceObject()->update_state(7);
    }
  }
  ////////////////////////
  public function update_startDelay($startDelay)
  {
    $this->startDelay = $startDelay;
    $this->sqlQuery = "UPDATE `claim` SET `Start_Delay` = '".$this->startDelay."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_description($description)
  {
    $this->description = $description;
    $this->sqlQuery = "UPDATE `claim` SET `Description` = '".$this->description."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_deadline($deadline)
  {
    $this->deadline = $deadline;
    $this->sqlQuery = "UPDATE `claim` SET `Deadline` = '".$this->deadline."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_delaySupport($delaySupport)
  {
    $this->delaySupport = $delaySupport;
    $this->sqlQuery = "UPDATE `claim` SET `Delay_Support` = '".$this->delaySupport."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_priority($priority)
  {
    $this->priority = $priority;
    $this->sqlQuery = "UPDATE `claim` SET `Priority` = '".$this->priority."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_totalDelay($totalDelay)
  {
    $this->totalDelay = $totalDelay;
    $this->sqlQuery = "UPDATE `claim` SET `Total_Delay` = '".$this->totalDelay."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_totalSpentTime($totalSpentTime)
  {
    $this->totalSpentTime = $totalSpentTime;
    $this->sqlQuery = "UPDATE `claim` SET `Total_Spent_Time` = '".$this->totalSpentTime."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_expectedDate($expectedDate)
  {
    $this->expectedDate = $expectedDate;
    $this->sqlQuery = "UPDATE `claim` SET `Expected_Date` = '".$this->expectedDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_possibleDate($possibleDate)
  {
    $this->possibleDate = $possibleDate;
    $this->sqlQuery = "UPDATE `claim` SET `Possible_Date` = '".$this->possibleDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_amount($amount)
  {
    $this->amount = $amount;
    $this->sqlQuery = "UPDATE `claim` SET `Amount` = '".$this->amount."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
}
 ?>
