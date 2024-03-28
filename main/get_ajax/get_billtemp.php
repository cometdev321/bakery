<?php
include('../common/cnn.php');
include('../common/session_control.php');



$query = "UPDATE tblpartyreport 
          SET 
            r_balance = CASE 
                          WHEN r_balance > p_balance THEN r_balance - p_balance 
                          ELSE 0 
                        END,
            p_balance = CASE 
                          WHEN p_balance > r_balance THEN p_balance - r_balance 
                          ELSE 0 
                        END";

$result = mysqli_query($conn, $query);





?>