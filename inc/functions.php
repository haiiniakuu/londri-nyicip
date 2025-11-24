<?php
function checkLogin(){
    if(!isset($_SESSION['ID'])){
        header("location:index.php?access=failed");
    }

}