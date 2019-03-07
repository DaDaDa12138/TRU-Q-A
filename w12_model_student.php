<?php
$conn = mysqli_connect('localhost', 'zwan', 'wzy258852', 'COMP3540_zwan');

function insert_new_user($username, $password, $email)
{
    global $conn;
    
    if (does_exist($username))
        return false;
    else {
        $current_date = date('Ymd');
        $hashed_password = sha1($password);  
      $sql = "insert into USERS value (null,'$username', '$hashed_password', '$email',$current_date)";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
}



function is_valid($username, $password) 
{
    global $conn;
    $hashed_password = sha1($password); 
    $sql = "select * from USERS where (USERNAME ='$username' AND PASSWORD ='$hashed_password')";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)  // check the number of selected rows
        return true;
    else
        return false;
}

function does_exist($username) 
{
    global $conn;  // inorderto use a global variable
    
    $sql = "select * from USERS where (USERNAME = '$username')";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)  // check the number of selected rows
        return true;
    else
        return false;
}

function get_userid($username)
{
    global $conn;
    
    $sql = "select * from USERS where (Username = '$username')";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['USERID'];
    }
    else
        return -1;
}

/*
*   Queries
*/

function post_question($q, $u)  // question, username
{
    global $conn;
    
    $uid = get_userid($u);  // use get_userid()
    if ($uid < 0)
        return false;
    
    $current_date = date('Ymd');
    $sql = "insert into Questions values (NULL, $uid, '$q', $current_date)";
    mysqli_query($conn, $sql);
    
    return true;
}

function list_questions($u)
{
    global $conn;
    
    $uid = get_userid($u);
    if ($uid < 0)
        return '';
    
    $sql = "select * from Questions where (UserId = $uid)";
    $result = mysqli_query($conn, $sql);
    $data = array();
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
        $data[$i++] = $row;
    
    return $data;
}
?>   