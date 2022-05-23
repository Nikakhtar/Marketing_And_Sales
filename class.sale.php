<?php
/**
 *
 */
class Sale
{
  private $id;
  private $application;
  private $manager;
  private $manager_Dsp;
  private $patron;
  private $contacts;
  private $patron_Dsp;
  private $product;
  private $product_Dsp;
  private $submitDate;
  private $finishDate;
  private $state;
  private $state_Dsp;
  private $description;
  public $db = "3369816905d579ef34e2094076840766";
  private $sqlQuery;
  ///////////////////////
  public function __construct($id = NULL, $application = NULL, $manager = NULL, $patron = NULL, $product = NULL, $submitDate = NULL, $description = NULL)
  {
    $g = new G();
    $g->loadClass('pmFunctions');
    if ($id == NULL) {
      $this->id = NULL;
      $this->application = $application;
      ///////////////////////////////
      $this->manager = $manager;
      $this->manager_Dsp = NULL;
      $this->patron = $patron;
      $this->patron_Dsp = NULL;
      $this->contacts = NULL;
      $this->product = $product;
      $this->product_Dsp = NULL;
      $this->submitDate = $submitDate;
      $this->finishDate = NULL;
      $this->state = 1;
      $this->state_Dsp = NULL;
      $this->description = $description;
      $this->id = $this->insert_sale();
    }
    elseif ($id != NULL) {
      $this->id = $id;
    }
  }
  //////////////////////
  private function insert_sale()
  {
    $this->sqlQuery = "INSERT INTO `sale`(`Id`, `Application`, `Manager`, `Patron`, `Product`, `Submit_Date`, `Finish_Date`, `State`, `Description`) VALUES(NULL, '$this->application', '$this->manager', '$this->patron', '$this->product', '$this->submitDate', '$this->finishDate', '$this->state', '$this->description')";
    executeQuery($this->sqlQuery, $this->db);
    $result = executeQuery("SELECT LAST_INSERT_ID()", $this->db);
    return $result['1']['LAST_INSERT_ID()'];
  }
  //////////////////////
  public function insert_contacts($contacts, $sale = NULL)
 {
   if (is_array($contacts)) {
     foreach ($contacts as $row) {
       $sale = $this->get_Id();
       $name = $row['Sale_contacts_name'];
       $contact = $row['Sale_contacts_contact'];
       $this->sqlQuery = "INSERT INTO `contacts`(`Id`, `Sale`, `Name`, `Contact`) VALUES(NULL, '$sale', '$name', '$contact')";
       executeQuery($this->sqlQuery, $this->db);
     }
   }
 }

  ///////////////////////
  public function get_id()
  {
    return $this->id;
  }
  ////////////////////////
  public function get_application()
  {
    $this->sqlQuery = "SELECT `sale`.`Application` AS Sale_application FROM `sale` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->application = $result[1]['Sale_application'];
    return $this->application;
  }
  ////////////////////////
  public function get_manager()
  {
    $this->sqlQuery = "SELECT `sale`.`Manager` AS Sale_manager FROM `sale` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager = $result[1]['Sale_manager'];
    return $this->manager;
  }
  ////////////////////////
  public function get_manager_Dsp()
  {
    $this->sqlQuery = "SELECT CONCAT(USR_FIRSTNAME, ' ', USR_LASTNAME) AS `Sale_manager` FROM `sale` INNER JOIN `bitnami_pm`.`users` ON `Manager` = `USR_UID` WHERE `sale`.`Id` ='".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->manager_Dsp = $result[1]['Sale_manager'];
    return $this->manager_Dsp;
  }
  /////////////////////////
  public function get_patron()
  {
    $this->sqlQuery = "SELECT `sale`.`Patron` AS Sale_patron FROM `sale` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->patron = $result[1]['Sale_patron'];
    return $this->patron;
  }
  ////////////////////////
  public function get_patron_Dsp()
  {
    $this->sqlQuery = "SELECT `patron`.`Name` AS Sale_patron FROM `patron` INNER JOIN `sale` ON `sale`.`Patron` = `patron`.`Id` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->patron_Dsp = $result[1]['Sale_patron'];
    return $this->patron_Dsp;
  }
  ////////////////////////
  public function get_contacts($lable1 = NULL, $lable2 = NULL, $lable3 = NULL, $lable4 = NULL)
  {
    $this->sqlQuery = "SELECT `contacts`.`Id` AS '".$lable1."', `contacts`.`Sale` AS '".$lable2."', `contacts`.`Name` AS '".$lable3."', `contacts`.`Contact` AS '".$lable4."' FROM `contacts` WHERE `contacts`.`Sale` = '".$this->id."'";
    $this->contacts = executeQuery($this->sqlQuery, $this->db);
    return $this->contacts;
  }
  ////////////////////////
  public function get_product()
  {
    $this->sqlQuery = "SELECT `sale`.`product` AS Sale_product FROM `sale` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->product = $result[1]['Sale_product'];
    return $this->product;
  }
  ////////////////////////
  public function get_product_Dsp()
  {
    $this->sqlQuery = "SELECT `product`.`Name` AS Sale_product FROM `product` INNER JOIN `sale` ON `sale`.`Product` = `product`.`Id` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->product_Dsp = $result[1]['Sale_product'];
    return $this->product_Dsp;
  }
  ////////////////////////
  public function get_submitDate()
  {
    $this->sqlQuery = "SELECT `sale`.`Submit_Date` AS Sale_submitDate FROM `sale` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->submitDate = $result[1]['Sale_submitDate'];
    return $this->submitDate;
  }
  ////////////////////////
  public function get_finishDate()
  {
    $this->sqlQuery = "SELECT `sale`.`Finish_Date` AS Sale_finishDate FROM `sale` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->finishDate = $result[1]['Sale_finishDate'];
    return $this->finishDate;
  }
  //////////////////////////
  public function get_state()
  {
    $this->sqlQuery = "SELECT `sale`.`State` AS Sale_state FROM `sale` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state = $result[1]['Sale_state'];
    return $this->state;
  }
  /////////////////////////
  public function get_state_Dsp()
  {
    $this->sqlQuery = "SELECT `sale_state`.`State` AS Sale_state FROM `sale_state` INNER JOIN `sale` ON `sale`.`State` = `sale_state`.`Id` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->state_Dsp = $result[1]['Marketing_state'];
    return $this->state_Dsp;
  }
  ////////////////////////
  public function get_description()
  {
    $this->sqlQuery = "SELECT `sale`.`Description` AS Sale_description FROM `sale` WHERE `sale`.`Id` = '".$this->id."'";
    $result = executeQuery($this->sqlQuery, $this->db);
    $this->description = $result[1]['Sale_description'];
    return $this->description;
  }
  ////////////////////////
  ///////////////////////
  //////////////////////
  public function update_id($id)
  {
    $this->id = $id;
    $this->sqlQuery = "UPDATE `sale` SET `Id` = '".$this->id."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////
  public function update_application($application)
  {
    $this->application = $application;
    $this->sqlQuery = "UPDATE `sale` SET `Application` = '".$this->application."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_manager($manager)
  {
    $this->manager = $manager;
    $this->sqlQuery = "UPDATE `sale` SET `Manager` = '".$this->manager."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  /////////////////////////
  public function update_patron($patron)
  {
    $this->patron = $patron;
    $this->sqlQuery = "UPDATE `sale` SET `Patron` = '".$this->patron."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_product($product)
  {
    $this->product = $product;
    $this->sqlQuery = "UPDATE `sale` SET `Product` = '".$this->product."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_submitDate($submitDate)
  {
    $this->submitDate = $submitDate;
    $this->sqlQuery = "UPDATE `sale` SET `Submit_Date` = '".$this->submitDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_finishDate($finishDate)
  {
    $this->finishDate = $finishDate;
    $this->sqlQuery = "UPDATE `sale` SET `Finish_Date` = '".$this->finishDate."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  //////////////////////////
  public function update_state($state)
  {
    $this->state = $state;
    $this->sqlQuery = "UPDATE `sale` SET `State` = '".$this->state."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
  ////////////////////////
  public function update_description($description)
  {
    $this->description = $description;
    $this->sqlQuery = "UPDATE `sale` SET `Description` = '".$this->description."' WHERE `Id` = '".$this->id."'";
    executeQuery($this->sqlQuery, $this->db);
  }
}
 ?>
