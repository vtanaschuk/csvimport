<?php
    require 'dbconnect.php';

if(isset($_POST['import'])){
    $fileName = $_FILES['file']['tmp_name'];
    if($_FILES['file']['size']>0) {


        $file = fopen($fileName, 'r');
        function daysCount($dataArr)
        {
            $sumDays = 0;
            for ($i = 0; $i < count($dataArr); $i++) {
                if ($i == 0) {
                    $sumDays += (int)$dataArr[$i];
                } else if ($i == 1) {
                    $sumDays += (int)$dataArr[$i] * 30;
                } else if ($i == 2) {
                    $sumDays += (int)$dataArr[$i] * 30 * 12;
                }
            }
            return $sumDays;
        }
        $update = 0;
        $insert = 0;
        $delete = 0;
        while (($column = fgetcsv($file, 1024, ',')) !== FALSE) {
            $select = "SELECT * FROM user WHERE uid = '$column[0]' ";
            $selectResult = mysqli_query($connection, $select);
            $fetchSelectResult = mysqli_fetch_assoc($selectResult);
            $csvArr = explode('/', $column[4]);
            if (isset($fetchSelectResult['dateChange'])) {
                $sqlArr = explode('/', $fetchSelectResult['dateChange']);
                $sqlSumDays = daysCount($sqlArr);
                $csvSumDays = daysCount($csvArr);
            }
            if ($fetchSelectResult['uid'] == $column[0] && $csvSumDays > $sqlSumDays) {
                $query = "UPDATE user SET
                                firstName   = '$column[1]',
                                lastName    = '$column[2]',
                                birthDay    = '$column[3]',
                                dateChange  = '$column[4]',
                                description = '$column[5]'
                                    WHERE uid= '$column[0]'";
                $queryResult = mysqli_query($connection, $query);
                if ($queryResult == true){
                    $update += 1;
                }
            } else if ($fetchSelectResult['uid'] == NULL) {
                $query = 'Insert into user (uid, firstName, lastName, birthDay, dateChange, description)
                        values("' . $column[0] . '","' . $column[1] . '","' . $column[2] . '","' . $column[3] . '","' . $column[4] . '","' . $column[5] . '")';
                $queryResult = mysqli_query($connection, $query);
                if ($queryResult == true){
                    $insert += 1;
                }
            }
            $array[] = $column[0];
        }
    }
        $query = "Delete FROM user WHERE uid NOT IN ( '" . implode( "', '" , $array ) . "' )";
        $queryResult = mysqli_query($connection, $query);
        header("Location: index.php=?update=$update&insert=$insert");
    }
?>
