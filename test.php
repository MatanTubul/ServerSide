<?php
/**
 * Created by PhpStorm.
 * User: matant
 * Date: 5/13/2015
 * Time: 1:29 PM
 */
error_reporting(0);
//ini_set("error_reporting", E_ALL & ~E_DEPRECATED);

require_once 'index.php';
$tag = $_POST['tag'];
$user = $_POST['paramUsername'];
$password = md5($_POST['paramPassword']);
$email = $_POST['paramEmail'];
$output = array();
$con = mysql_connect('localhost','root','');
if (!$con)
{
    die('could not connect:'.mysql_error());
}
mysql_select_db('api',$con);
$fn = new Functions();

if($tag == "login")
{


    $result = mysql_query("SELECT * FROM users WHERE users.usern ='$user'");

    if(!$result){
        $output["error_msg"] = "query failed";
        print(json_encode($output));
    }
    $no_of_rows = mysql_num_rows($result);

    if ($no_of_rows > 0){
        $row = mysql_fetch_assoc($result);
        if($password == $row["password"])
        {
            $output["user"] = $row;
            $output["msg"]="working";
            print(json_encode($output));
        }else
        {
            $output["dbpassword"] = $row["password"];
            $output["password"] = $password;
            $output["msg"]="Password or user is incorrect!";
            print(json_encode($output));
        }

    }


    else{
        $output["msg"]="user was not found";
        print(json_encode($output));
    }
    mysql_close($con);
}
elseif($tag == "insert")
{

    $result = mysql_query("INSERT INTO users (usern , email , password) VALUES ('$user' , '$email' , '$password')");
    if(!$result)
    {
        $output["msg"] = "failed";
        $output["error_msg"] = "insert failed";
        print(json_encode($output));
    }else{
        $output["msg"] = "insert working";
        print(json_encode($output));
    }

}
else {
    $output["msg"] = "not working";
    $output["error_msg"] = "tag param is missing";
    print(json_encode($output));
}

?>
