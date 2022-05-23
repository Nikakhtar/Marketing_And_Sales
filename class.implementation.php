<?php
require_once ("classes/class.invoice.php");
/**
 *
 */
class Implementation
{
  private $id;
  private $invoice;
  private $manager;
  private $manager_Dsp;
  private $header;
  private $submitDate;
  private $latestReviewDate;
  private $reviewer;
  private $reviewer_Dsp;
  private $state;
  private $state_Dsp;
  private $startDelay;
  private $totalDelay;
  private $totalSpentTime;
  private $supportInterval;
  private $supportStartDate;
  private $warrantyInterval;
  private $warrantyStartDate;
  private $expectedStartDate;
  private $expectedFinishDate;
  private $startDate;
  private $finishDate;
  private $remainingDays;
  private $supportedDays;
  private $deadline;
  private $transaction;
  private $description;
  private $priority;
  private $invoiceObject;
  private $current_transaction_Deadline;
  public $db = "4673515545dd01ae9d55a21047128918";
                                                      //6107969645dead733730727019431710
  private $sqlQuery;
  /////////////////
  public function __construct($id = NULL, $manager = NULL, $header = NULL, $submitDate = NULL, $supportInterval = NULL, $supportStartDate = NULL, $warrantyInterval = NULL, $warrantyStartDate = NULL, $expectedStartDate = NULL, $expectedFinishDate = NULL, $startDate = NULL, $finishDate = NULL, $deadline = NULL, $remainingDays = NULL, $startDelay = NULL, $description = NULL, $priority = NULL, $invoiceObject)
  {
    $g = new G();
    $g->loadClass('pmFunctions');
    if ($id == NULL) {
      $this->set_invoiceObject($invoiceObject);
      $this->invoice = $this->invoiceObject->get_id();
      $this->manager = $manager;
      $this->manager_Dsp = NULL;
      $this->header = $header;
      $this->submitDate = $submitDate;
      $this->supportInterval = $supportInterval;
      $this->supportStartDate = $supportStartDate;
      $this->warrantyInterval = $warrantyInterval;
      $this->warrantyStartDate = $warrantyStartDate;
      $this->expectedStartDate = $expectedStartDate;
      $this->expectedfinishDate = $expectedFinishDate;
      $this->startDate = $startDate;
      $this->finishDate = $finishDate;
      $this->supportedDays = NULL;
      $this->deadline = $deadline;
      $this->remainingDays = $remainingDays;
      $this->latestReviewDate = NULL;
      $this->reviewer = NULL;
      $this->reviewer_Dsp = NULL;
      $this->state = 1;
      $this->state_Dsp = NULL;
      $this->startDelay = $startDelay;
      $this->totalDelay = 0;
      $this->totalSpentTime = 0;
      $this->transaction = NULL;
      $this->description = $description;
      $this->deadline = $deadline;
      $this->priority = $priority;
      $this->id = $this->insert_implementation();
      if ($this->id != NULL) {
        $this->get_invoiceObject()->update_state(11);
      }
    }
    elseif ($id != NULL) {
      $this->id = $id;
    }
  }
  ////////////////////
  private function insert_implementation()
  {
    $this->sqlQuery = "INSERT INTO `implementation`(`Id`, `Invoice`, `Manager`, `Header`, `Submit_Date`, `Latest_Review_Date`, `Reviewer`, `State`, `Start_Delay`, `Total_Delay`, `Total_Spent_Time`, `Support_Interval`, `Support_Start_Date`, `Warranty_Interval`, `Warranty_Start_Date`, `Expected_Start_Date`, `Expected_Finish_Date`, `Start_Date`, `Finish_Date`, `Remaining_Days`, `Supported_Days`, `Description`, `Priority`, `Deadline`) VALUES(NULL, '$this->invoice', '$this->manager', '$this->header', '$this->submitDate', '$this->latestReviewDate', '$this->reviewer', '$this->state', '$this->startDelay', '$this->totalDelay', '$this->totalSpentTime', '$this->supportInterval', '$this->supportStartDate', '$this->warrantyInterval', '$this->warrantyStartDate', '$this->expectedStartDate', '$this->expectedFinishDate', '$this->startDate', '$this->finishDate', '$this->remainingDays', '$this->supportedDays', '$this->description', '$this->priority', '$this->deadline')";
    executeQuery($this->sqlQuery, $this->db);
    $result = executeQuery("SELECT LAST_INSERT_ID()", $this->db);
    return $result[1]['LAST_INSERT_ID()'];
  }
  ////////////////////
  public function insert_implementation_transaction($owner, $description, $submitDate, $spentTime, $result, $passTo)
  {
    $this->sqlQuery = "INSERT INTO `implementation_transaction`(`Id`, `Implementation`, `Owner`, `Description`, `Submit_Date`, `Spent_Time`, `Result`, `Pass_To`) VALUES(NULL, '$this->id', '$owner', '$description', '$submitDate', '$spentTime', '$result', '$passTo')";
    executeQuery($this->sqlQuery, $this->db);
    if ($result == 1) {
      $this->update_state(1);
    }
    elseif ($result == 2) {
      $this->get_invoiceObject()->update_state(12);
    }
    elseif ($result == 3) {
      $this->get_invoiceObject()->update_state(13);
    }
    //elseif ($result == 4) {
      //$this->update_state(4);
    //}
  }
  ////////////////////
  /*public function insert_implementation_document($archivist, $depositDate, $depositAmount, $bank, $valueAdded, $insuranceCost, $tax, $depositCost, $documentLink)
  {
    $this->sqlQuery = "INSERT INTO `implementation_document`(`Id`, `Implementation`, `Archivist`, `Deposit_Date`, `Deposit_Amount`, `Bank`, `Value_Added`, `Insurance_Cost`, `Tax`, `Deposit_Cost`, `Document_Link`) VALUES(NULL, '$this->id', '$archivist', '$depositDate', '$depositAmount', '$bank', '$valueAdded', '$insuranceCost', '$tax', '$depositCost', '$documentLink')";
    executeQuery($this->sqlQuery, $this->db);
  }
  */
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
    $this->sqlQuery = "SELECT `implementation`.`Invoice` AS Implementation_invoice FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->invoice = $result[1]['Implementation_invoice'];
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
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Implementation_manager` FROM `implementation` INNER JOIN `bitnami_pm`.`users` ON `Manager` = `USR_UID` WHERE `implementation`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager_Dsp = $result[1]['Implementation_manager'];
    return $this->manager_Dsp;
  }
    ////////////////////////
  public function get_manager()
  {
    $this->sqlQuery = "SELECT `implementation`.`Manager` AS Implementation_manager FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager = $result[1]['Implementation_manager'];
    return $this->manager;
  }
  ////////////////////////
  public function get_header()
  {
    $this->sqlQuery = "SELECT `implementation`.`Header` AS Implementation_header FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->header = $result[1]['Implementation_header'];
    return $this->header;
  }
  /////////////////////////
  public function get_submitDate()
  {
    $this->sqlQuery = "SELECT `implementation`.`Submit_Date` AS Implementation_submitDate FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->submitDate = $result[1]['Implementation_submitDate'];
    return $this->submitDate;
  }
  /////////////////////////
  public function get_supportInterval()
  {
    $this->sqlQuery = "SELECT `implementation`.`Support_Interval` AS Implementation_supportInterval FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->supportInterval = $result[1]['Implementation_supportInterval'];
    return $this->supportInterval;
  }
  /////////////////////////
  public function get_supportStartDate()
  {
    $this->sqlQuery = "SELECT `implementation`.`Support_Start_Date` AS Implementation_supportStartDate FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->supportStartDate = $result[1]['Implementation_supportStartDate'];
    return $this->supportStartDate;
  }
  /////////////////////////
  public function get_warrantyInterval()
  {
    $this->sqlQuery = "SELECT `implementation`.`Warranty_Interval` AS Implementation_warrantyInterval FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->warrantyInterval = $result[1]['Implementation_warrantyInterval'];
    return $this->warrantyInterval;
  }
  /////////////////////////
  public function get_warrantyStartDate()
  {
    $this->sqlQuery = "SELECT `implementation`.`Warranty_Start_Date` AS Implementation_warrantyStartDate FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->warrantyStartDate = $result[1]['Implementation_warrantyStartDate'];
    return $this->warrantyStartDate;
  }
  /////////////////////////
  public function get_expectedStartDate()
  {
    $this->sqlQuery = "SELECT `implementation`.`Expected_Start_Date` AS Implementation_expectedStartDate FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->expectedStartDate = $result[1]['Implementation_expectedStartDate'];
    return $this->expectedStartDate;
  }
  /////////////////////////
  public function get_expectedFinishDate()
  {
    $this->sqlQuery = "SELECT `implementation`.`Expected_Finish_Date` AS Implementation_expectedFinishDate FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->expectedFinishDate = $result[1]['Implementation_expectedFinishDate'];
    return $this->expectedFinishDate;
  }
  /////////////////////////
  public function get_startDate()
  {
    $this->sqlQuery = "SELECT `implementation`.`Start_date` AS Implementation_startDate FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->startDate = $result[1]['Implementation_startDate'];
    return $this->startDate;
  }
  /////////////////////////
  public function get_finishDate()
  {
    $this->sqlQuery = "SELECT `implementation`.`Finish_Date` AS Implementation_finishDate FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->finishDate = $result[1]['Implementation_finishDate'];
    return $this->finishDate;
  }
  /////////////////////////
  public function get_supportedDays()
  {
    $this->sqlQuery = "SELECT `implementation`.`Supported_Days` AS Implementation_supportedDays FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->supportedDays = $result[1]['Implementation_supportedDays'];
    return $this->supportedDays;
  }
  /////////////////////////
  public function get_remainingDays()
  {
    $this->sqlQuery = "SELECT `implementation`.`Remaining_Days` AS Implementation_remainingDays FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->remainingDays = $result[1]['Implementation_remainingDays'];
    return $this->remainingDays;
  }
  ////////////////////////
  public function get_latestReviewDate()
  {
    $this->sqlQuery = "SELECT `implementation`.`Latest_Review_Date` AS Implementation_latestReviewDate FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->latestReviewDate = $result[1]['Implementation_latestReviewDate'];
    return $this->latestReviewDate;
  }
  //////////////////////////
  public function get_reviewer()
  {
    $this->sqlQuery = "SELECT `implementation`.`Reviewer` AS Implementation_reviewer FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer = $result[1]['Implementation_reviewer'];
    return $this->reviewer;
  }
  //////////////////////////
  public function get_reviewer_Dsp()
  {
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Implementation_reviewer` FROM `implementation` INNER JOIN `bitnami_pm`.`users` ON `Reviewer` = `USR_UID` WHERE `implementation`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer_Dsp = $result[1]['Implementation_reviewer'];
    return $this->reviewer_Dsp;
  }
  //////////////////////////
  public function get_state()
  {
    $this->sqlQuery = "SELECT `implementation`.`State` AS Implementation_state FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state = $result[1]['Implementation_state'];
    return $this->state;
  }
  ////////////////////////
  public function get_state_Dsp()
  {
    $this->sqlQuery = "SELECT `state`.`State` AS Implementation_state FROM `state` INNER JOIN `implementation` ON `implementation`.`State` = `state`.`Id` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state_Dsp = $result[1]['Implementation_state'];
    return $this->state_Dsp;
  }
  ////////////////////////
  public function get_startDelay()
  {
    $this->sqlQuery = "SELECT `implementation`.`Start_Delay` AS Implementation_startDelay FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->startDelay = $result[1]['Implementation_startDelay'];
    return $this->startDelay;
  }
  ////////////////////////
  public function get_description()
  {
    $this->sqlQuery = "SELECT `implementation`.`Description` AS Implementation_description FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->description = $result[1]['Implementation_description'];
    return $this->description;
  }
  ////////////////////////
  public function get_deadline()
  {
    $this->sqlQuery = "SELECT `implementation`.`Deadline` AS Implementation_deadline FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->deadline = $result[1]['Implementation_deadline'];
    return $this->deadline;
  }
  ////////////////////////
  public function get_priority()
  {
    $this->sqlQuery = "SELECT `implementation`.`Priority` AS Implementation_priority FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->priority = $result[1]['Implementation_priority'];
    return $this->priority;
  }
  ////////////////////////
  public function get_totalDelay()
  {
    $this->sqlQuery = "SELECT `implementation`.`Total_Delay` AS Implementation_totalDelay FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->totalDelay = $result[1]['Implementation_totalDelay'];
    return $this->totalDelay;
  }
  ////////////////////////////////////////////////
  public function get_totalSpentTime()
  {
    $this->sqlQuery = "SELECT `implementation`.`Total_Spent_Time` AS Implementation_totalSpentTime FROM `implementation` WHERE `implementation`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->totalSpentTime = $result[1]['Implementation_totalSpentTime'];
    return $this->totalSpentTime;
  }
  ////////////////////////////////////////////////
  public function get_transaction($lable1 = NULL, $lable2 = NULL, $lable3 = NULL, $lable4 = NULL, $lable5 = NULL, $lable6 = NULL, $lable7 = NULL, $lable8 = NULL)
  {
    $this->sqlQuery = "SELECT `implementation_transaction`.`Id` AS '".$lable1."', `implementation_transaction`.`Implementation` AS '".$lable2."', CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS '".$lable3."', `implementation_transaction`.`Description` AS '".$lable4."', `implementation_transaction`.`Submit_Date` AS '".$lable5."', `implementation_transaction`.`Spent_Time` AS '".$lable6."', `holding_result`.`Result` AS '".$lable7."', `implementation_transaction`.`Pass_To` AS '".$lable8."' FROM `implementation_transaction` LEFT JOIN `holding_result` ON `implementation_transaction`.`Result` = `holding_result`.`Id` INNER JOIN `bitnami_pm`.`users` ON `Owner` = `USR_UID` WHERE `implementation_transaction`.`Implementation` = '".$this->id."'";
    $this->transaction = executeQuery($this->sqlQuery, $this->db);
    return $this->transaction;
  }
  ////////////////////////////////////////////////
/*
  public function get_document($lable1 = NULL, $lable2 = NULL, $lable3 = NULL, $lable4 = NULL, $lable5 = NULL, $lable6 = NULL, $lable7 = NULL, $lable8 = NULL, $lable9 = NULL, $lable10 = NULL, $lable11 = NULL)
  {
    $this->sqlQuery = "SELECT `implementation_document`.`Id` AS '".$lable1."', `implementation_document`.`Implementation` AS '".$lable2."', CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS '".$lable3."', `implementation_document`.`Deposit_Date` AS '".$lable4."', `implementation_document`.`Deposit_Amount` AS '".$lable5."', `implementation_document`.`Bank` AS '".$lable6."', `implementation_document`.`Value_Added` AS '".$lable7."', `implementation_document`.`Insurance_Cost` AS '".$lable8."', `implementation_document`.`Tax` AS '".$lable9."', `implementation_document`.`Deposit_Cost` AS '".$lable10."', `implementation_document`.`Document_Link` AS '".$lable11."' FROM `implementation_document` INNER JOIN `bitnami_pm`.`users` ON `Archivist` = `USR_UID` WHERE `implementation_document`.`Implementation` = '".$this->id."'";
    $this->document = executeQuery($this->sqlQuery, $this->db);
    return $this->document;
  }
  */
  ////////////////////////
  ////////////////////////
  ///////////////////////
  //////////////////////
  public function update_id($id)
  {
    $this->id = $id;
    $this->sqlQuery = "UPDATE `implementation` SET `Id` = '".$this->id."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_manager($manager)
  {
    $this->manager = $manager;
    $this->sqlQuery = "UPDATE `implementation` SET `Manager` = '".$this->manager."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  /////////////////////////
  public function update_invoice($invoice)
  {
    $this->invoice = $invoice;
    $this->sqlQuery = "UPDATE `implementation` SET `invoice` = '".$this->invoice."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_submitDate($submitDate)
  {
    $this->submitDate = $submitDate;
    $this->sqlQuery = "UPDATE `implementation` SET `Submit_Date` = '".$this->submitDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_supportInterval($supportInterval)
  {
    $this->supportInterval = $supportInterval;
    $this->sqlQuery = "UPDATE `implementation` SET `Support_Interval` = '".$this->supportInterval."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_supportStartDate($supportStartDate)
  {
    $this->submitDate = $submitDate;
    $this->sqlQuery = "UPDATE `implementation` SET `Support_Start_Date` = '".$this->supportInterval."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_warrantyInterval($warrantyInterval)
  {
    $this->warrantyInterval = $warrantyInterval;
    $this->sqlQuery = "UPDATE `implementation` SET `Warranty_Interval` = '".$this->warrantyInterval."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_warrantyStartDate($warrantyStartDate)
  {
    $this->warrantyStartDate = $warrantyStartDate;
    $this->sqlQuery = "UPDATE `implementation` SET `Warranty_Start_Date` = '".$this->warrantyStartDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_expectedStartDate($expectedStartDate)
  {
    $this->expectedStartDate = $expectedStartDate;
    $this->sqlQuery = "UPDATE `implementation` SET `Expected_Start_Date` = '".$this->expectedStartDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_expectedFinishDate($expectedFinishDate)
  {
    $this->expectedFinishDate = $expectedFinishDate;
    $this->sqlQuery = "UPDATE `implementation` SET `Expected_Finish_Date` = '".$this->expectedFinishDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_startDate($startDate)
  {
    $this->startDate = $startDate;
    $this->sqlQuery = "UPDATE `implementation` SET `Start_Date` = '".$this->startDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_finishDate($finishDate)
  {
    $this->finishDate = $finishDate;
    $this->sqlQuery = "UPDATE `implementation` SET `Finish_Date` = '".$this->finishDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_supportedDays($supportedDays)
  {
    $this->supportedDays = $supportedDays;
    $this->sqlQuery = "UPDATE `implementation` SET `Supported_Days` = '".$this->supportedDays."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_remainingDays($remainingDays)
  {
    $this->remainingDays = $remainingDays;
    $this->sqlQuery = "UPDATE `implementation` SET `Remaining_Days` = '".$this->remainingDays."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_latestReviewDate($latestReviewDate)
  {
    $this->latestReviewDate = $latestReviewDate;
    $this->sqlQuery = "UPDATE `implementation` SET `Latest_Review_Date` = '".$this->latestReviewDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_reviewer($reviewer)
  {
    $this->reviewer = $reviewer;
    $this->sqlQuery = "UPDATE `implementation` SET `Reviewer` = '".$this->reviewer."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_state($state)
  {
    $this->state = $state;
    $this->sqlQuery = "UPDATE `implementation` SET `State` = '".$this->state."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
    if ($state == 1) {
      $this->get_invoiceObject()->update_state(11);
    }
    elseif ($state == 2) {
      $this->get_invoiceObject()->update_state(15);
    }
    elseif ($state == 3) {
      $this->get_invoiceObject()->update_state(16);
    }
    elseif ($state == 4) {
      $this->get_invoiceObject()->update_state(14);
    }
  }
  ////////////////////////
  public function update_startDelay($startDelay)
  {
    $this->startDelay = $startDelay;
    $this->sqlQuery = "UPDATE `implementation` SET `Start_Delay` = '".$this->startDelay."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_description($description)
  {
    $this->description = $description;
    $this->sqlQuery = "UPDATE `implementation` SET `Description` = '".$this->description."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_deadline($deadline)
  {
    $this->deadline = $deadline;
    $this->sqlQuery = "UPDATE `implementation` SET `Deadline` = '".$this->deadline."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_delaySupport($delaySupport)
  {
    $this->delaySupport = $delaySupport;
    $this->sqlQuery = "UPDATE `implementation` SET `Delay_Support` = '".$this->delaySupport."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_priority($priority)
  {
    $this->priority = $priority;
    $this->sqlQuery = "UPDATE `implementation` SET `Priority` = '".$this->priority."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_totalDelay($totalDelay)
  {
    $this->totalDelay = $totalDelay;
    $this->sqlQuery = "UPDATE `implementation` SET `Total_Delay` = '".$this->totalDelay."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_totalSpentTime($totalSpentTime)
  {
    $this->totalSpentTime = $totalSpentTime;
    $this->sqlQuery = "UPDATE `implementation` SET `Total_Spent_Time` = '".$this->totalSpentTime."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
}
 ?>
