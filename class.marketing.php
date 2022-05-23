<?php
require_once ("classes/class.sale.php");
/**
 *
 */
class Marketing
{
  private $id;
  private $sale;
  private $manager;
  private $manager_Dsp;
  private $submitDate;
  private $latestReviewDate;
  private $reviewer;
  private $reviewer_Dsp;
  private $state;
  private $state_Dsp;
  private $totalDelay;
  private $totalSpentTime;
  private $holding;
  private $description;
  private $priority;
  private $saleObject;
  private $current_holding_Deadline;
  public $db = "3369816905d579ef34e2094076840766";
  private $sqlQuery;
  /////////////////
  public function __construct($id = NULL, $manager = NULL, $submitDate = NULL, $description = NULL, $priority = NULL, $saleObject)
  {
    $g = new G();
    $g->loadClass('pmFunctions');
    if ($id == NULL) {
      $this->set_saleObject($saleObject);
      $this->sale = $this->saleObject->get_id();
      $this->manager = $manager;
      $this->manager_Dsp = NULL;
      $this->submitDate = $submitDate;
      $this->latestReviewDate = NULL;
      $this->reviewer = NULL;
      $this->reviewer_Dsp = NULL;
      $this->state = 1;
      $this->state_Dsp = NULL;
      $this->totalDelay = 0;
      $this->totalSpentTime = 0;
      $this->holding = NULL;
      $this->current_holding_Deadline = NULL;
      $this->description = $description;
      $this->priority = $priority;
      $this->id = $this->insert_marketing();
      if ($this->id != NULL ) {
        $this->get_saleObject()->update_state(1);
      }
    }
    elseif ($id != NULL) {
      $this->id = $id;
    }
  }
  ////////////////////
  private function insert_marketing()
  {
    $this->sqlQuery = "INSERT INTO `marketing`(`Id`, `Sale`, `Manager`, `Submit_Date`, `Latest_Review_Date`, `Reviewer`, `State`, `Total_Delay`, `Total_Spent_Time`, `Description`, `Priority`) VALUES(NULL, '$this->sale', '$this->manager', '$this->submitDate', '$this->latestReviewDate', '$this->reviewer', '$this->state', '$this->totalDelay', '$this->totalSpentTime', '$this->description', '$this->priority')";
    executeQuery($this->sqlQuery, $this->db);
    $result = executeQuery("SELECT LAST_INSERT_ID()", $this->db);
    return $result['1']['LAST_INSERT_ID()'];
  }
  ////////////////////
  public function insert_marketing_holding($owner, $description, $submitDate, $deadline, $spentTime, $result, $passTo)
  {
    $this->sqlQuery = "INSERT INTO `marketing_holding`(`Id`, `Marketing`, `Owner`, `Description`, `Submit_Date`, `Deadline`, `Delay`, `Spent_Time`, `Result`, `Pass_To`) VALUES(NULL, '$this->id', '$owner', '$description', '$submitDate', '$deadline', NULL, '$spentTime', '$result', '$passTo')";
    executeQuery($this->sqlQuery, $this->db);
    if ($result == 1) {
      $this->update_state(1);
    }
    elseif ($result == 2) {
      $this->get_saleObject()->update_state(2);
    }
    elseif ($result == 3) {
      $this->get_saleObject()->update_state(3);
    }
    elseif ($result == 4) {
      $this->update_state(4);
    }
    $this->current_holding_Deadline = $deadline;
  }
  //////////////////////
  public function set_saleObject($saleObject)
  {
    $this->saleObject = $saleObject;
  }
  //////////////////////
  public function get_id()
  {
    return $this->id;
  }
  ////////////////////////
  public function get_sale()
  {
    $this->sqlQuery = "SELECT `marketing`.`Sale` AS Marketing_sale FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->sale = $result[1]['Marketing_sale'];
    return $this->sale;
  }
  ////////////////////////
  public function get_saleObject()
  {
    $this->saleObject = new Sale($this->get_sale(), NULL, NULL, NULL, NULL, NULL, NULL);
    $this->saleObject = unserialize(serialize ($this->saleObject));
    $this->saleObject->db = $this->db;
    return $this->saleObject;
  }
  ////////////////////////
  public function get_manager_Dsp()
  {
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Marketing_manager` FROM `marketing` INNER JOIN `bitnami_pm`.`users` ON `Manager` = `USR_UID` WHERE `marketing`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager_Dsp = $result[1]['Marketing_manager'];
    return $this->manager_Dsp;
  }
    ////////////////////////
  public function get_manager()
  {
    $this->sqlQuery = "SELECT `marketing`.`Manager` AS Marketing_manager FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager = $result[1]['Marketing_manager'];
    return $this->manager;
  }
  /////////////////////////
  public function get_submitDate()
  {
    $this->sqlQuery = "SELECT `marketing`.`Submit_Date` AS Marketing_submitDate FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->submitDate = $result[1]['Marketing_submitDate'];
    return $this->submitDate;
  }
  ////////////////////////
  public function get_latestReviewDate()
  {
    $this->sqlQuery = "SELECT `marketing`.`Latest_Review_Date` AS Marketing_latestReviewDate FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->latestReviewDate = $result[1]['Marketing_latestReviewDate'];
    return $this->latestReviewDate;
  }
  //////////////////////////
  public function get_reviewer()
  {
    $this->sqlQuery = "SELECT `marketing`.`Reviewer` AS Marketing_reviewer FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer = $result[1]['Marketing_reviewer'];
    return $this->reviewer;
  }
  //////////////////////////
  public function get_reviewer_Dsp()
  {
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Marketing_reviewer` FROM `marketing` INNER JOIN `bitnami_pm`.`users` ON `Reviewer` = `USR_UID` WHERE `marketing`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer_Dsp = $result[1]['Marketing_reviewer'];
    return $this->reviewer_Dsp;
  }
  //////////////////////////
  public function get_state()
  {
    $this->sqlQuery = "SELECT `marketing`.`State` AS Marketing_state FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state = $result[1]['Marketing_state'];
    return $this->state;
  }
  ////////////////////////
  public function get_state_Dsp()
  {
    $this->sqlQuery = "SELECT `state`.`State` AS Marketing_state FROM `state` INNER JOIN `marketing` ON `marketing`.`State` = `state`.`Id` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state_Dsp = $result[1]['Marketing_state'];
    return $this->state_Dsp;
  }
  ////////////////////////
  public function get_description()
  {
    $this->sqlQuery = "SELECT `marketing`.`Description` AS Marketing_description FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->description = $result[1]['Marketing_description'];
    return $this->description;
  }
  ////////////////////////
  public function get_priority()
  {
    $this->sqlQuery = "SELECT `marketing`.`Priority` AS Marketing_priority FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->priority = $result[1]['Marketing_priority'];
    return $this->priority;
  }
  ////////////////////////
  public function get_totalDelay()
  {
    $this->sqlQuery = "SELECT `marketing`.`Total_Delay` AS Marketing_totalDelay FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->totalDelay = $result[1]['Marketing_totalDelay'];
    return $this->totalDelay;
  }
  ////////////////////////////////////////////////
  public function get_totalSpentTime()
  {
    $this->sqlQuery = "SELECT `marketing`.`Total_Spent_Time` AS Marketing_totalSpentTime FROM `marketing` WHERE `marketing`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->totalSpentTime = $result[1]['Marketing_totalSpentTime'];
    return $this->totalSpentTime;
  }
  ////////////////////////////////////////////////
  public function get_holding($lable1 = NULL, $lable2 = NULL, $lable3 = NULL, $lable4 = NULL, $lable5 = NULL, $lable6 = NULL, $lable7 = NULL, $lable8 = NULL, $lable9 = NULL, $lable10 = NULL)
  {
    $this->sqlQuery = "SELECT `marketing_holding`.`Id` AS '".$lable1."', `marketing_holding`.`Marketing` AS '".$lable2."', CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS '".$lable3."', `marketing_holding`.`Description` AS '".$lable4."', `marketing_holding`.`Submit_Date` AS '".$lable5."', `marketing_holding`.`Deadline` AS '".$lable6."', `marketing_holding`.`Delay` AS '".$lable7."', `marketing_holding`.`Spent_Time` AS '".$lable8."', `holding_result`.`Result` AS '".$lable9."', `marketing_holding`.`Pass_To` AS '".$lable10."' FROM `marketing_holding` LEFT JOIN `holding_result` ON `marketing_holding`.`Result` = `holding_result`.`Id` INNER JOIN `bitnami_pm`.`users` ON `Owner` = `USR_UID` WHERE `marketing_holding`.`Marketing` = '".$this->id."'";
    $this->holding = executeQuery($this->sqlQuery, $this->db);
    return $this->holding;
  }
  //////////////////////
  public function get_current_holding_Deadline()
  {
    //$this->sqlQuery = "SELECT `Deadline` FROM(SELECT * FROM `marketing_holding` WHERE `marketing_holding`.`Marketing` = '".$this->id."') WHERE `Id` = (SELECT MAX(id) FROM TABLE)";
    //$this->sale = executeQuery($this->sqlQuery, $this->db);
    //return $this->current_holding_Deadline;
  }
  ////////////////////////
  ////////////////////////
  ///////////////////////
  //////////////////////
  public function update_id($id)
  {
    $this->id = $id;
    $this->sqlQuery = "UPDATE `marketing` SET `Id` = '".$this->id."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_manager($manager)
  {
    $this->manager = $manager;
    $this->sqlQuery = "UPDATE `marketing` SET `Manager` = '".$this->manager."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  /////////////////////////
  public function update_sale($sale)
  {
    $this->sale = $sale;
    $this->sqlQuery = "UPDATE `marketing` SET `Sale` = '".$this->sale."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_submitDate($submitDate)
  {
    $this->submitDate = $submitDate;
    $this->sqlQuery = "UPDATE `marketing` SET `Submit_Date` = '".$this->submitDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_latestReviewDate($latestReviewDate)
  {
    $this->latestReviewDate = $latestReviewDate;
    $this->sqlQuery = "UPDATE `marketing` SET `Latest_Review_Date` = '".$this->latestReviewDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_reviewer($reviewer)
  {
    $this->reviewer = $reviewer;
    $this->sqlQuery = "UPDATE `marketing` SET `Reviewer` = '".$this->reviewer."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_state($state)
  {
    $this->state = $state;
    $this->sqlQuery = "UPDATE `marketing` SET `State` = '".$this->state."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
    if ($state == 1) {
      $this->get_saleObject()->update_state(1);
    }
    elseif ($state == 2) {
      $this->get_saleObject()->update_state(5);
    }
    elseif ($state == 3) {
      $this->get_saleObject()->update_state(6);
    }
    elseif ($state == 4) {
      $this->get_saleObject()->update_state(4);
    }
  }
  ////////////////////////
  public function update_description($description)
  {
    $this->description = $description;
    $this->sqlQuery = "UPDATE `marketing` SET `Description` = '".$this->description."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_priority($priority)
  {
    $this->priority = $priority;
    $this->sqlQuery = "UPDATE `marketing` SET `Priority` = '".$this->priority."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_totalDelay($totalDelay)
  {
    $this->totalDelay = $totalDelay;
    $this->sqlQuery = "UPDATE `marketing` SET `Total_Delay` = '".$this->totalDelay."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_totalSpentTime($totalSpentTime)
  {
    $this->totalSpentTime = $totalSpentTime;
    $this->sqlQuery = "UPDATE `marketing` SET `Total_Spent_Time` = '".$this->totalSpentTime."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
}
 ?>
