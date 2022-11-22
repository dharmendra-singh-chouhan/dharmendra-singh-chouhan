<?php
function dbconnect() {
    $conn = mysqli_connect("localhost", "ubuy", "ubuy@123", "jquery");
    return $conn;
}
