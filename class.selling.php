<?php
require_once ("classes/class.sale.php");
/**
 *
 */
class Selling
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
  private $expectedDate;
  private $possibleDate;
  private $expectedIncome;
  private $possibleIncome;
  private $realIncome;
  private $type;
  private $successPercentage;
  private $holding;
  private $description;
  private $contractDocNumber;
  private $priority;
  private $saleObject;
  private $current_holding_Deadline;
  public $db = "3369816905d579ef34e2094076840766";
  private $sqlQuery;
  /////////////////
  public function __construct($id = NULL, $manager = NULL, $submitDate = NULL, $expectedDate = NULL, $possibleDate = NULL, $expectedIncome = NULL, $possibleIncome = NULL, $type = NULL, $successPercentage = NULL, $description = NULL, $priority = NULL, $saleObject)
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
      $this->expectedDate = $expectedDate;
      $this->possibleDate = $possibleDate;
      $this->expectedIncome = $expectedIncome;
      $this->possibleIncome = $possibleIncome;
      $this->realIncome = NULL;
      $this->type = $type;
      $this->successPercentage = $successPercentage;
      $this->holding = NULL;
      $this->current_holding_Deadline = NULL;
      $this->description = $description;
      $this->contractDocNumber = NULL;
      $this->priority = $priority;
      $this->id = $this->insert_selling();
      if ($this->id != NULL) {
        $this->get_saleObject()->update_state(7);
      }
    }
    elseif ($id != NULL) {
      $this->id = $id;
    }
  }
  ////////////////////
  private function insert_selling()
  {
    $this->sqlQuery = "INSERT INTO `selling`(`Id`, `Sale`, `Manager`, `Submit_Date`, `Latest_Review_Date`, `Reviewer`, `State`, `Total_Delay`, `Total_Spent_Time`, `Expected_Date`, `Possible_Date`, `Expected_Income`, `Possible_Income`, `Real_Income`, `Type`, `Success_Percentage`, `Description`, `ContractDoc_Number`, `Priority`) VALUES(NULL, '$this->sale', '$this->manager', '$this->submitDate', '$this->latestReviewDate', '$this->reviewer', '$this->state', '$this->totalDelay', '$this->totalSpentTime', '$this->expectedDate', '$this->possibleDate', '$this->expectedIncome', '$this->possibleIncome', '$this->realIncome', '$this->type', '$this->successPercentage', '$this->description', '$this->contractDocNumber', '$this->priority')";
    executeQuery($this->sqlQuery, $this->db);
    $result = executeQuery("SELECT LAST_INSERT_ID()", $this->db);
    return $result['1']['LAST_INSERT_ID()'];
  }
  ////////////////////
  public function insert_selling_holding($owner, $description, $submitDate, $deadline, $spentTime, $result, $passTo)
  {
    $this->sqlQuery = "INSERT INTO `selling_holding`(`Id`, `Selling`, `Owner`, `Description`, `Submit_Date`, `Deadline`, `Delay`, `Spent_Time`, `Result`, `Pass_To`) VALUES(NULL, '$this->id', '$owner', '$description', '$submitDate', '$deadline', NULL, '$spentTime', '$result', '$passTo')";
    executeQuery($this->sqlQuery, $this->db);
    if ($result == 1) {
      $this->update_state(1);
    }
    elseif ($result == 2) {
      $this->get_saleObject()->update_state(8);
    }
    elseif ($result == 3) {
      $this->get_saleObject()->update_state(9);
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
    $this->sqlQuery = "SELECT `selling`.`Sale` AS Selling_sale FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->sale = $result[1]['Selling_sale'];
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
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Selling_manager` FROM `selling` INNER JOIN `bitnami_pm`.`users` ON `Manager` = `USR_UID` WHERE `selling`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager_Dsp = $result[1]['Selling_manager'];
    return $this->manager_Dsp;
  }
    ////////////////////////
  public function get_manager()
  {
    $this->sqlQuery = "SELECT `selling`.`Manager` AS Selling_manager FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager = $result[1]['Selling_manager'];
    return $this->manager;
  }
  /////////////////////////
  public function get_submitDate()
  {
    $this->sqlQuery = "SELECT `selling`.`Submit_Date` AS Selling_submitDate FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->submitDate = $result[1]['Selling_submitDate'];
    return $this->submitDate;
  }
  ////////////////////////
  public function get_latestReviewDate()
  {
    $this->sqlQuery = "SELECT `selling`.`Latest_Review_Date` AS Selling_latestReviewDate FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->latestReviewDate = $result[1]['Selling_latestReviewDate'];
    return $this->latestReviewDate;
  }
  //////////////////////////
  public function get_reviewer()
  {
    $this->sqlQuery = "SELECT `selling`.`Reviewer` AS Selling_reviewer FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer = $result[1]['Selling_reviewer'];
    return $this->reviewer;
  }
  //////////////////////////
  public function get_reviewer_Dsp()
  {
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Selling_reviewer` FROM `selling` INNER JOIN `bitnami_pm`.`users` ON `Reviewer` = `USR_UID` WHERE `selling`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->reviewer_Dsp = $result[1]['Selling_reviewer'];
    return $this->reviewer_Dsp;
  }
  //////////////////////////
  public function get_state()
  {
    $this->sqlQuery = "SELECT `selling`.`State` AS Selling_state FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state = $result[1]['Selling_state'];
    return $this->state;
  }
  ////////////////////////
  public function get_state_Dsp()
  {
    $this->sqlQuery = "SELECT `state`.`State` AS Selling_state FROM `state` INNER JOIN `selling` ON `selling`.`State` = `state`.`Id` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state_Dsp = $result[1]['Selling_state'];
    return $this->state_Dsp;
  }
  ////////////////////////
  public function get_description()
  {
    $this->sqlQuery = "SELECT `selling`.`Description` AS Selling_description FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->description = $result[1]['Selling_description'];
    return $this->description;
  }
  ////////////////////////
  public function get_contractDocNumber()
  {
    $this->sqlQuery = "SELECT `selling`.`ContractDoc_Number` AS Selling_contractDocNumber FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->contractDocNumber = $result[1]['Selling_contractDocNumber'];
    return $this->contractDocNumber;
  }
  ////////////////////////
  public function get_priority()
  {
    $this->sqlQuery = "SELECT `selling`.`Priority` AS Selling_priority FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->priority = $result[1]['Selling_priority'];
    return $this->priority;
  }
  ////////////////////////
  public function get_totalDelay()
  {
    $this->sqlQuery = "SELECT `selling`.`Total_Delay` AS Selling_totalDelay FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->totalDelay = $result[1]['Selling_totalDelay'];
    return $this->totalDelay;
  }
  ////////////////////////////////////////////////
  public function get_totalSpentTime()
  {
    $this->sqlQuery = "SELECT `selling`.`Total_Spent_Time` AS Selling_totalSpentTime FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->totalSpentTime = $result[1]['Selling_totalSpentTime'];
    return $this->totalSpentTime;
  }
  ////////////////////////////////////////////////
  public function get_expectedDate()
  {
    $this->sqlQuery = "SELECT `selling`.`Expected_Date` AS Selling_expectedDate FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->expectedDate = $result[1]['Selling_expectedDate'];
    return $this->expectedDate;
  }
  ////////////////////////////////////////////////
  public function get_possibleDate()
  {
    $this->sqlQuery = "SELECT `selling`.`Possible_Date` AS Selling_possibleDate FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->possibleDate = $result[1]['Selling_possibleDate'];
    return $this->possibleDate;
  }
  ////////////////////////////////////////////////
  public function get_expectedIncome()
  {
    $this->sqlQuery = "SELECT `selling`.`Expected_Income` AS Selling_expectedIncome FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->expectedIncome = $result[1]['Selling_expectedIncome'];
    return $this->expectedIncome;
  }
  ////////////////////////////////////////////////
  public function get_possibleIncome()
  {
    $this->sqlQuery = "SELECT `selling`.`Possible_Income` AS Selling_possibleIncome FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->possibleIncome = $result[1]['Selling_possibleIncome'];
    return $this->possibleIncome;
  }
  ////////////////////////////////////////////////
  public function get_realIncome()
  {
    $this->sqlQuery = "SELECT `selling`.`Real_Income` AS Selling_realIncome FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->realIncome = $result[1]['Selling_realIncome'];
    return $this->realIncome;
  }
  ////////////////////////////////////////////////
  public function get_type()
  {
    $this->sqlQuery = "SELECT `selling`.`Type` AS Selling_type FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->type = $result[1]['Selling_type'];
    return $this->type;
  }
  ////////////////////////
  public function get_type_Dsp()
  {
    $this->sqlQuery = "SELECT `selling_type`.`Type` AS Selling_type FROM `selling_type` INNER JOIN `selling` ON `selling`.`Type` = `selling_type`.`Id` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->type_Dsp = $result[1]['Selling_type'];
    return $this->type_Dsp;
  }
  ////////////////////////////////////////////////
  public function get_successPercentage()
  {
    $this->sqlQuery = "SELECT `selling`.`Success_Percentage` AS Selling_successPercentage FROM `selling` WHERE `selling`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->successPercentage = $result[1]['Selling_successPercentage'];
    return $this->successPercentage;
  }
  ////////////////////////////////////////////////
  public function get_holding($lable1 = NULL, $lable2 = NULL, $lable3 = NULL, $lable4 = NULL, $lable5 = NULL, $lable6 = NULL, $lable7 = NULL, $lable8 = NULL, $lable9 = NULL, $lable10 = NULL)
  {
    $this->sqlQuery = "SELECT `selling_holding`.`Id` AS '".$lable1."', `selling_holding`.`Selling` AS '".$lable2."', CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS '".$lable3."', `selling_holding`.`Description` AS '".$lable4."', `selling_holding`.`Submit_Date` AS '".$lable5."', `selling_holding`.`Deadline` AS '".$lable6."', `selling_holding`.`Delay` AS '".$lable7."', `selling_holding`.`Spent_Time` AS '".$lable8."', `holding_result`.`Result` AS '".$lable9."', `selling_holding`.`Pass_To` AS '".$lable10."' FROM `selling_holding` LEFT JOIN `holding_result` ON `selling_holding`.`Result` = `holding_result`.`Id` INNER JOIN `bitnami_pm`.`users` ON `Owner` = `USR_UID` WHERE `selling_holding`.`Selling` = '".$this->id."'";
    $this->holding = executeQuery($this->sqlQuery, $this->db);
    return $this->holding;
  }
  //////////////////////
  public function get_current_holding_Deadline()
  {
    //$this->sqlQuery = "SELECT `Deadline` FROM(SELECT * FROM `selling_holding` WHERE `selling_holding`.`Selling` = '".$this->id."') WHERE `Id` = (SELECT MAX(id) FROM TABLE)";
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
    $this->sqlQuery = "UPDATE `selling` SET `Id` = '".$this->id."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_manager($manager)
  {
    $this->manager = $manager;
    $this->sqlQuery = "UPDATE `selling` SET `Manager` = '".$this->manager."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  /////////////////////////
  public function update_sale($sale)
  {
    $this->sale = $sale;
    $this->sqlQuery = "UPDATE `selling` SET `Sale` = '".$this->sale."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_submitDate($submitDate)
  {
    $this->submitDate = $submitDate;
    $this->sqlQuery = "UPDATE `selling` SET `Submit_Date` = '".$this->submitDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_latestReviewDate($latestReviewDate)
  {
    $this->latestReviewDate = $latestReviewDate;
    $this->sqlQuery = "UPDATE `selling` SET `Latest_Review_Date` = '".$this->latestReviewDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_reviewer($reviewer)
  {
    $this->reviewer = $reviewer;
    $this->sqlQuery = "UPDATE `selling` SET `Reviewer` = '".$this->reviewer."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_state($state)
  {
    $this->state = $state;
    $this->sqlQuery = "UPDATE `selling` SET `State` = '".$this->state."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
    if ($state == 1) {
      $this->get_saleObject()->update_state(7);
    }
    elseif ($state == 2) {
      $this->get_saleObject()->update_state(11);
    }
    elseif ($state == 3) {
      $this->get_saleObject()->update_state(12);
    }
    elseif ($state == 4) {
      $this->get_saleObject()->update_state(10);
    }
  }
  ////////////////////////
  public function update_description($description)
  {
    $this->description = $description;
    $this->sqlQuery = "UPDATE `selling` SET `Description` = '".$this->description."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_contractDocNumber($contractDocNumber)
  {
    $this->contractDocNumber = $contractDocNumber;
    $this->sqlQuery = "UPDATE `selling` SET `ContractDoc_Number` = '".$this->contractDocNumber."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_priority($priority)
  {
    $this->priority = $priority;
    $this->sqlQuery = "UPDATE `selling` SET `Priority` = '".$this->priority."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_totalDelay($totalDelay)
  {
    $this->totalDelay = $totalDelay;
    $this->sqlQuery = "UPDATE `selling` SET `Total_Delay` = '".$this->totalDelay."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_totalSpentTime($totalSpentTime)
  {
    $this->totalSpentTime = $totalSpentTime;
    $this->sqlQuery = "UPDATE `selling` SET `Total_Spent_Time` = '".$this->totalSpentTime."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_expectedDate($expectedDate)
  {
    $this->expectedDate = $expectedDate;
    $this->sqlQuery = "UPDATE `selling` SET `Expected_Date` = '".$this->expectedDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_possibleDate($possibleDate)
  {
    $this->possibleDate = $possibleDate;
    $this->sqlQuery = "UPDATE `selling` SET `Possible_Date` = '".$this->possibleDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_expectedIncome($expectedIncome)
  {
    $this->expectedIncome = $expectedIncome;
    $this->sqlQuery = "UPDATE `selling` SET `Expected_Income` = '".$this->expectedIncome."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_possibleIncome($possibleIncome)
  {
    $this->possibleIncome = $possibleIncome;
    $this->sqlQuery = "UPDATE `selling` SET `Possible_Income` = '".$this->possibleIncome."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_realIncome($realIncome)
  {
    $this->realIncome = $realIncome;
    $this->sqlQuery = "UPDATE `selling` SET `Real_Income` = '".$this->realIncome."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_type($type)
  {
    $this->type = $type;
    $this->sqlQuery = "UPDATE `selling` SET `Type` = '".$this->type."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_successPercentage($successPercentage)
  {
    $this->successPercentage = $successPercentage;
    $this->sqlQuery = "UPDATE `selling` SET `Success_Percentage` = '".$this->successPercentage."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
}
 ?>
