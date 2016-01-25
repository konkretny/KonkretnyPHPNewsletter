<?php
/*
Author: Marcin Romanowicz
URL: http://konkretny.pl/
License: MIT
Version: 1.1.1
*/
class KonkretnyPHPNewsletter{
    
    //mail settings
    private $content;
    private $limit;
    private $my_mail;
    private $mails;
    private $title;
    private $from;
    
    //db settings
    private $database_type;
    private $pqsqlschema;
    private $host;
    private $db_name;
    private $port;
    private $db_user;
    private $db_password;
    
    //mail table settings
    private $tablename;
    private $columnname;
    
    
    public function __construct() {
        $this->content='';
        $this->limit=0;
        $this->my_mail='';
        $this->mails='';
        $this->title='';
        $this->from='';
        
        $this->database_type=0;
        $this->pqsqlschema='';
        $this->host='';
        $this->db_name='';
        $this->port='';
        $this->db_user='';
        $this->db_password='';
        
        $this->tablename='';
        $this->columnname='';
    }
    
    public function setTablename($tablename) {
        $this->tablename = $tablename;
    }

    public function setColumnname($columnname) {
        $this->columnname = $columnname;
    }

        
    public function setMy_mail($my_mail) {
        $this->my_mail = $my_mail;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
    }

    public function setDatabase_type($database_type) {
        $this->database_type = $database_type;
    }

    public function setPqsqlschema($pqsqlschema) {
        $this->pqsqlschema = $pqsqlschema;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function setDb_name($db_name) {
        $this->db_name = $db_name;
    }

    public function setPort($port) {
        $this->port = $port;
    }

    public function setDb_user($db_user) {
        $this->db_user = $db_user;
    }

    public function setDb_password($db_password) {
        $this->db_password = $db_password;
    }

        
    public function pdo_read(){
        
        //query and limits
        if(strlen($this->limit)>1){
            $query = 'SELECT '.$this->columnname.' FROM '.$this->tablename.' LIMIT '.$this->limit;
        }
        else{
            $query = 'SELECT '.$this->columnname.' FROM '.$this->tablename;    
        }
        //PDO connect
        if(strlen($this->db_name)>0){
            if($this->port==''){$port_nr='';}else{$port_nr=';port='.$this->port;}
            if($this->database_type==0){$database_type='mysql:';}elseif($this->database_type==1){$database_type='pgsql:';}else{echo 'error database type';exit;}
            try {
                      $PDO = new PDO($database_type.'host='.$this->host.$port_nr.';dbname='.$this->db_name, $this->db_user, $this->db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                      if(strlen($this->pqsqlschema)>0){$PDO->exec('SET search_path TO '.$this->pqsqlschema);}
            }
            catch(PDOException $e) {
                     echo 'Connection error: ' . $e->getMessage();
            }
        }

        //get mails from DB
        try{
                $qr = $PDO->prepare($query);
                $qr->execute();
                $result = array_filter($qr->fetchAll());
                $qr->closeCursor();
            }
            catch(PDOException $e) {
                echo 'Connection error: ' . $e->getMessage();
        }
        $this->mails = $result;
    }
    
    
    public function sendmassmail(){
        $header = "Content-type: text/html; charset=UTF-8"."\r\n"."From: $this->from <$this->my_mail>";

        $counter=0;
        foreach($this->mails as $mailadress){
            mail(trim($mailadress[$this->columnname]), $this->title, $this->content, $header);
            $counter++;
        }
        return $counter;   
    }

}
?>