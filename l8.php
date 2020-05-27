<?php 
session_start();
define("LOCALHOST","127.0.0.1");
define("LOGIN","root");
define("PASSWORD","123456");
define("BASE","l8");

?>
<head>
<style>
    body{
    background-color: #444;
    color: #aaa;
}    
 td {
            width: 10px;
            border: 1px solid;
        }
        
</style>
</head>
<body>

<?php 
try {
    $db = new PDO('mysql:host='.LOCALHOST.';dbname='.BASE.';charset=utf8',LOGIN,PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  
  } catch (PDOException $e) {
    //echo "Connection failed : ". $e->POSTMessage();
}

$query = "select * from `connection` where `addr`=:addr and `proxy`=:proxy and `forwarded`=:forwarded";
    $stmt = $db->prepare($query);
    $stmt->bindParam('addr', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
    $forw="";
    $proxy=isset($_SERVER['HTTP_X_FORWARDED_FOR']);
    if($proxy)
    {
        $forw=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    $stmt->bindParam('proxy', $proxy, PDO::PARAM_BOOL);
    $stmt->bindParam('forwarded', $forw, PDO::PARAM_STR);
    $stmt->execute();
   if($stmt->rowCount()==0){
       echo"added";
    $query = "insert into `connection` (addr, proxy, forwarded) VALUES (:addr,:proxy,:forwarded)";
    $stmt = $db->prepare($query);
    $stmt->bindParam('addr', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
    $stmt->bindParam('proxy', $proxy, PDO::PARAM_BOOL);
    $stmt->bindParam('forwarded', $forw, PDO::PARAM_STR);
    $stmt->execute();
   }else{
    echo"exist";
    $query = "UPDATE `connection` SET `count` = `count` +1  where `addr`=:addr and `proxy`=:proxy and `forwarded`=:forwarded";
    $stmt = $db->prepare($query);
    $stmt->bindParam('addr', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
    $stmt->bindParam('proxy', $proxy, PDO::PARAM_BOOL);
    $stmt->bindParam('forwarded', $forw, PDO::PARAM_STR);
    $stmt->execute();  
    }

    $query = "select * from `connection` ORDER BY `count` desc";
    $stmt = $db->prepare($query);
    $stmt->execute();
    echo "<table><tr><th>count</th><th>address</th><th>proxy</th><th>forwarded</th></tr>";
    unset($_SESSION['graph']);
    $_SESSION['count']=0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $cr=rand(0,255);
        $cg=rand(0,255);
        $cb=rand(0,255);
        $colstr='#'.sprintf('%02x', ($cr)).sprintf('%02x', ($cg)).sprintf('%02x', ($cb));
        echo '<tr  style="background-color:'.$colstr.'">'.
        '<td>'.$row['count'].'</td>'.
        '<td>'.$row['addr'].'</td>'.
        '<td>'.$row['proxy'].'</td>'.
        '<td>'.$row['forwarded'].'</td>'.
        "</tr>";
        $_SESSION['count']+=$row['count'];
        $_SESSION['graph'][]= array($row['count'],$cr,$cg,$cb);
        // $_SESSION['graph'][]= array($row['count'],$row['addr'],$row['proxy'],$row['forwarded'],$cr,$cg,$cb);
    }
    echo "</table>";

//echo $_SERVER['REMOTE_ADDR'];






//var_dump($_SESSION['graph']);
?>

</body>