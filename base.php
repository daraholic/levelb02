<?php
date_default_timezone_set("Asia/Taipei");
session_start();

class DB{
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=web02";
    protected $user="root";
    protected $pw="";
    protected $pdo;
    public $table;

    public function __construct($table){
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,$this->user,$this->pw);    
    }
    
    
    public function find($id){
        $sql="SELECT * FROM $this->table WHERE ";
        if(is_array($id)){
            foreach($id as $key => $value){
                $tmp[]="`$key`='$value'";
            }
            $sql .= implode(" AND ",$tmp);
        }else{
            $sql .=" `id`='$id'";
        }
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function all(...$arg){
        $sql="SELECT * FROM $this->table ";
        switch(count($arg)){
            case 2:
                foreach($arg[0] as $key => $value){
                    $tmp[]="`$key`='$value'";
                }
                $sql .="WHERE ".implode(" AND ",$tmp)." ".$arg[1];

                break;
            case 1:
                if(is_array($arg[0])){
                    foreach($arg[0] as $key => $value){
                        $tmp[]="`$key`='$value'";
                    }
                    $sql .= "WHERE ".implode(" AND ",$tmp);
                }else{
                    $sql .= $arg[0];
                }
            break;
        }
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function math($method,$col,...$arg){
        $sql="SELECT $method($col) FROM $this->table ";

        switch(count($arg)){
            case 2:
                foreach($arg[0] as $key => $value){
                    $tmp[]="`$key`='$value'";
                }

                $sql .=" WHERE ".implode(" AND ",$tmp)." ".$arg[1];

            break;
            case 1:
                if(is_array($arg[0])){
                    foreach($arg[0] as $key => $value){
                        $tmp[]="`$key`='$value'";
                    }
                    $sql .= " WHERE ".implode(" AND ",$tmp);
                }else{
                    $sql .= $arg[0];
                    
                }
            break;
        }


        return $this->pdo->query($sql)->fetchColumn();
    }
    public function save($array){
        if(isset($array['id'])){
            // update
            foreach($array as $key => $value){
                $tmp[]="`$key`='$value'";
            }
            $sql="UPDATE $this->table 
                    SET ".implode(",",$tmp)." 
                    WHERE `id`='{$array['id']}'";
        }else{
            // insert
            $sql="INSERT INTO $this->table (`".implode("`,`",array_keys($array))."`)
                                   VALUES('".implode("','",$array)."')";

        }
        // echo $sql;
        return $this->pdo->exec($sql);

    }
    
    public function del($id){
        $sql="DELETE FROM $this->table WHERE ";
        if(is_array($id)){
            foreach($id as $key => $value){
                $tmp[]="`$key`='$value'";
            }
            $sql .= implode(" AND ",$tmp);
        }else{
            $sql .=" `id`='$id'";
        }
        // echo $sql;
        return $this->pdo->exec($sql);
    }
    public function q($sql){
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}

function to($url){
    header("location:".$url);
}

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

// 大寫變數代表資料表資料
$User=new DB('user');
$News=new DB('news');
$View=new DB('view');
$Que=new DB('que');
$log=new DB('log');



// 先找有無今日瀏覽人數紀錄
// 有 瀏覽人次+1
// 無 增加今天一筆新紀錄 瀏覽人次1
if(!isset($_SESSION['view'])){
    if($View->math('count','*',['date'=>date("Y-m-d")])>0){
        $view=$View->find(['date'=>date("Y-m-d")]);
        $view['total']+=1;
        $View->save($view);
        // 用session紀錄起來
        $_SESSION['view']=$view['total'];
    }else{
        $View->save(['date'=>date("Y-m-d"),'total'=>1]);
        $_SESSION['view']=1;
    }
}
