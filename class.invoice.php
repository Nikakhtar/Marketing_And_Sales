<?php
require_once ("classes/class.selling.php");
/**
 *
 */
class Invoice
{
  private $id;
  private $selling;
  private $owner;
  private $owner_Dsp;
  private $submitDate;
  private $reviewDate;
  private $reviewer;
  private $reviewer_Dsp;
  private $type;
  private $type_Dsp;
  private $implementationPriority;
  private $implementationPriority_Dsp;
  private $implementationDeadline;
  private $claimDeadline;
  private $price;
  private $implementationTopic;
  private $state;
  private $state_Dsp;
  private $description;
  private $sellingObject;
  public $db = "5356636985dc701a869dc65052746964";
  private $sqlQuery;
  /////////////////
  public function __construct($id = NULL)
  {
    $g = new G();
    $g->loadClass('pmFunctions');
    if ($id != NULL)
    {
    $this->id = $id;
    }
  }
  ////////////////////
  public function insert_invoice($list, $sellingObject, $owner, $submitDate)
  {
    if (is_array($list)) {
      $this->selling = $sellingObject->get_id();
      $this->submitDate = $submitDate;
      $this->owner = $owner;
      $this->state = 1;
      foreach ($list as $row) {
        $this->type = $row['Invoice_type'];
        $this->implementationPriority = $row['Invoice_implementationPriority'];
        $this->implementationDeadline = $row['Invoice_implementationDeadline'];
        $this->claimDeadline = $row['Invoice_claimDeadline'];
        $this->price = $row['Invoice_price'];
        $this->implementationTopic = $row['Invoice_implementationTopic'];
        $this->description = $row['Invoice_description'];
        $this->sqlQuery = "INSERT INTO `invoice`(`Id`, `Selling`, `Owner`, `Submit_Date`, `Reviewer`, `Review_Date`, `Type`, `Implementation_Priority`, `Implementation_Deadline`, `Claim_Deadline`, `Price`, `Implementation_Topic`, `State`, `Description`) VALUES(NULL, '$this->selling', '$this->owner', '$this->submitDate', 'NULL', 'NULL', '$this->type', '$this->implementationPriority', '$this->implementationDeadline', '$this->claimDeadline', '$this->price', '$this->implementationTopic', '$this->state', '$this->description')";
        executeQuery($this->sqlQuery, $this->db);
      }
    }
  }
  ////////////////////
  public function get_trimmedInvoiceId($prevId, $sellingObject)
  {
    $this->selling = $sellingObject->get_id();
    $this->sqlQuery = "SELECT MIN(Id) AS Invoice_id FROM `invoice` WHERE `invoice`.`Selling` = '".$this->selling."' AND `invoice`.`Id` > '".$prevId."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $id = $result[1]['Invoice_id'];
    $this->id = $id;
    return $this->id;
    //$invoice = new Invoice($id);
    //return $invoice;
  }
  ////////////////////
  public function get_latestInvoiceId($sellingObject)
  {
    $this->selling = $sellingObject->get_id();
    $this->sqlQuery = "SELECT MAX(Id) AS Invoice_id FROM `invoice` WHERE `invoice`.`Selling` = '".$this->selling."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $id = $result[1]['Invoice_id'];
    $this->id = $id;
    return $this->id;
    //$invoice = new Invoice($id);
    //return $invoice;
  }
  //////////////////////
  public function set_sellingObject($sellingObject)
  {
    $this->sellingObject = $sellingObject;
  }
  //////////////////////
  public function get_id()
  {
    return $this->id;
  }
  ////////////////////////
  public function get_selling()
  {
    $this->sqlQuery = "SELECT `invoice`.`Selling` AS Invoice_selling FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->selling = $result[1]['Invoice_selling'];
    return $this->selling;
  }
  ////////////////////////
  public function get_sellingObject()
  {
    $this->sellingObject = new Selling($this->get_selling(), NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
    $this->sellingObject = unserialize(serialize ($this->sellingObject));
    $this->sellingObject->db = $this->db;
    return $this->sellingObject;
  }
  ////////////////////////
  public function get_owner_Dsp()
  {
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Invoice_owner` FROM `invoice` INNER JOIN `bitnami_pm`.`users` ON `Owner` = `USR_UID` WHERE `invoice`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->owner_Dsp = $result[1]['Invoice_owner'];
    return $this->owner_Dsp;
  }
    ////////////////////////
  public function get_owner()
  {
    $this->sqlQuery = "SELECT `invoice`.`Owner` AS Invoice_owner FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->owner = $result[1]['Invoice_owner'];
    return $this->owner;
  }
  /////////////////////////
  public function get_submitDate()
  {
    $this->sqlQuery = "SELECT `invoice`.`Submit_Date` AS Invoice_submitDate FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->submitDate = $result[1]['Invoice_submitDate'];
    return $this->submitDate;
  }
  ////////////////////////
  public function get_reviewDate()
  {
    $this->sqlQuery = "SELECT `invoice`.`Review_Date` AS Invoice_reviewDate FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewDate = $result[1]['Invoice_reviewDate'];
    return $this->reviewDate;
  }
  //////////////////////////
  public function get_reviewer()
  {
    $this->sqlQuery = "SELECT `invoice`.`Reviewer` AS Invoice_reviewer FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer = $result[1]['Invoice_reviewer'];
    return $this->reviewer;
  }
  //////////////////////////
  public function get_reviewer_Dsp()
  {
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Invoice_reviewer` FROM `invoice` INNER JOIN `bitnami_pm`.`users` ON `Reviewer` = `USR_UID` WHERE `invoice`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer_Dsp = $result[1]['Invoice_reviewer'];
    return $this->reviewer_Dsp;
  }
  ////////////////////////
  public function get_type()
  {
    $this->sqlQuery = "SELECT `invoice`.`Type` AS Invoice_type FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->type = $result[1]['Invoice_type'];
    return $this->type;
  }
  ////////////////////////
  public function get_type_Dsp()
  {
    $this->sqlQuery = "SELECT `invoice_type`.`Type` AS Invoice_type FROM `invoice_type` INNER JOIN `invoice` ON `invoice`.`Type` = `invoice_type`.`Id` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->type_Dsp = $result[1]['Invoice_type'];
    return $this->type_Dsp;
  }
  ////////////////////////////////////////////////
  public function get_implementationPriority()
  {
    $this->sqlQuery = "SELECT `invoice`.`Implementation_Priority` AS Invoice_implementationPriority FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->implementationPriority = $result[1]['Invoice_implementationPriority'];
    return $this->implementationPriority;
  }
  ////////////////////////////////////////////////
  public function get_implementationPriority_Dsp()
  {
    $this->sqlQuery = "SELECT `invoice_implementation_priority`.`Priority` AS Invoice_implementationPriority FROM `invoice_implementation_priority` INNER JOIN `invoice` ON `invoice`.`Implementation_Priority` = `invoice_implementation_priority`.`Id` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->implementationPriority_Dsp = $result[1]['Invoice_implementationPriority'];
    return $this->implementationPriority_Dsp;
  }
  ////////////////////////////////////////////////
  public function get_implementationDeadline()
  {
    $this->sqlQuery = "SELECT `invoice`.`Implementation_Deadline` AS Invoice_implementationDeadline FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->implementationDeadline = $result[1]['Invoice_implementationDeadline'];
    return $this->implementationDeadline;
  }
  ////////////////////////////////////////////////
  public function get_claimDeadline()
  {
    $this->sqlQuery = "SELECT `invoice`.`Claim_Deadline` AS Invoice_claimDeadline FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->claimDeadline = $result[1]['Invoice_claimDeadline'];
    return $this->claimDeadline;
  }
  ////////////////////////////////////////////////
  public function get_price()
  {
    $this->sqlQuery = "SELECT `invoice`.`Price` AS Invoice_price FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->price = $result[1]['Invoice_price'];
    return $this->price;
  }
  ////////////////////////////////////////////////
  public function get_implementationTopic()
  {
    $this->sqlQuery = "SELECT `invoice`.`Implementation_Topic` AS Invoice_implementationTopic FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->implementationTopic = $result[1]['Invoice_implementationTopic'];
    return $this->implementationTopic;
  }
  ////////////////////////
  public function get_state()
  {
    $this->sqlQuery = "SELECT `invoice`.`State` AS Invoice_state FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state = $result[1]['Invoice_state'];
    return $this->state;
  }
  ////////////////////////
  public function get_state_Dsp()
  {
    $this->sqlQuery = "SELECT `invoice_state`.`State` AS Invoice_state FROM `invoice_state` INNER JOIN `invoice` ON `invoice`.`State` = `invoice_state`.`Id` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state_Dsp = $result[1]['Invoice_state'];
    return $this->state_Dsp;
  }
  ////////////////////////
  public function get_description()
  {
    $this->sqlQuery = "SELECT `invoice`.`Description` AS Invoice_description FROM `invoice` WHERE `invoice`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->description = $result[1]['Invoice_description'];
    return $this->description;
  }
  ////////////////////////
  ////////////////////////
  ///////////////////////
  //////////////////////
  public function update_id($id)
  {
    $this->id = $id;
    $this->sqlQuery = "UPDATE `invoice` SET `Id` = '".$this->id."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_owner($owner)
  {
    $this->owner = $owner;
    $this->sqlQuery = "UPDATE `invoice` SET `Owner` = '".$this->owner."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  /////////////////////////
  public function update_selling($selling)
  {
    $this->selling = $selling;
    $this->sqlQuery = "UPDATE `invoice` SET `Selling` = '".$this->selling."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_submitDate($submitDate)
  {
    $this->submitDate = $submitDate;
    $this->sqlQuery = "UPDATE `invoice` SET `Submit_Date` = '".$this->submitDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_reviewDate($reviewDate)
  {
    $this->reviewDate = $reviewDate;
    $this->sqlQuery = "UPDATE `invoice` SET `Review_Date` = '".$this->reviewDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_reviewer($reviewer)
  {
    $this->reviewer = $reviewer;
    $this->sqlQuery = "UPDATE `invoice` SET `Reviewer` = '".$this->reviewer."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_type($type)
  {
    $this->type = $type;
    $this->sqlQuery = "UPDATE `invoice` SET `Type` = '".$this->type."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_implementationPriority($implementationPriority)
  {
    $this->implementationPriority = $implementationPriority;
    $this->sqlQuery = "UPDATE `invoice` SET `Implementation_Priority` = '".$this->implementationPriority."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_implementationDeadline($implementationDeadline)
  {
    $this->implementationDeadline = $implementationDeadline;
    $this->sqlQuery = "UPDATE `invoice` SET `Implementation_Deadline` = '".$this->implementationDeadline."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_description($description)
  {
    $this->description = $description;
    $this->sqlQuery = "UPDATE `invoice` SET `Description` = '".$this->description."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_claimDeadline($claimDeadline)
  {
    $this->claimDeadline = $claimDeadline;
    $this->sqlQuery = "UPDATE `invoice` SET `Claim_Deadline` = '".$this->claimDeadline."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_price($price)
  {
    $this->price = $price;
    $this->sqlQuery = "UPDATE `invoice` SET `Price` = '".$this->price."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_implementationTopic($implementationTopic)
  {
    $this->implementationTopic = $implementationTopic;
    $this->sqlQuery = "UPDATE `invoice` SET `Implementation_Topic` = '".$this->implementationTopic."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_state($state)
  {
    $this->state = $state;
    $this->sqlQuery = "UPDATE `invoice` SET `State` = '".$this->state."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
}
 ?>
