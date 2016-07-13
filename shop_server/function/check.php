<?php
require_once("mysql.php");
/** 
 * @function check_token
 * @desc 验证token 
 * @param string $username 用户名 
 * @param string $token    
 * @return bool 
 */

function check_token($username, $token) {
  $conn = mysql_open();
  $sql = "select token_id from token where content = '$token' and username = '$username'";
  // echo $sql;
  $query = mysqli_query($conn, $sql);
  $sql1 = "select is_admin from user where username = '$username'";
  $query1 = mysqli_query($conn, $sql1);
  mysqli_close($conn);
  $result = mysqli_fetch_object($query)->token_id;
  $result1 = mysqli_fetch_object($query1)->is_admin;
  if($result != "" && $result1 != ""){
    $checkResult = $result1;
  }else{
    $checkResult = -1;
  }
  return $checkResult;
}

/**
 * @function update_token
 * @desc 更新token时间
 * @params string username 
 * @params string token
 * @return
 */
function update_token($username, $token){
  $conn = mysql_open();
  $time = date("Y-m-d H:s:i");
  $sql = "update token set update_time = NOW() where username = '$username' and content = '$token'";
  $query = mysqli_query($conn, $sql);
  mysqli_close($conn);
  if($query) return 1;
  else return 0;
}

/**
 * @function clean_input
 * @params input
 */
function clean_input($input){
  $input = str_replace("'", "", $input);
  return $input;
}
?>