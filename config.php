<?php
class Connect extends PDO
{
  public function _construct(){

    parent::_construct("mysql:hots=localHost;dbname=bancoUNAM",'root','',
    array("PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8));
    $this->setAttribute(PDO::ATR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $this->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
  }
}
?>