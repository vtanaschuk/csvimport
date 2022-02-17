<head>
    <style>
        .result{
            display: flex;
            flex-direction: column;
            padding-bottom: 15px;
            margin-bottom: 30px;
            border-bottom: 1px solid gray;
        }
        p{
            margin: 5px 0;
        }
        .result p span{
            font-weight: bold;
        }
        .top{
            display: flex;
            flex-direction: row;
            background-color: gray;
        }
        .top p{
            margin: 5px;
        }

    </style>
</head>
<body>
<?php
    require 'dbconnect.php';
?>
<form action="action.php" method="post" name="uploadCsv" enctype="multipart/form-data">
    <input type="file" name="file" accept=".csv">
    <button type="submit" name="import">Import</button>
</form>

<?php
echo '<div class="top">';
echo '<p>update: '.$_GET["update"].'<p>';
echo '<p> insert: '.$_GET["insert"].'<p>';
echo '</div>';

$selectView = "SELECT * FROM user";
$viewResult = mysqli_query($connection, $selectView);
if (mysqli_num_rows($viewResult)>0){
    while ($row = mysqli_fetch_array($viewResult)){
        echo '<div class="result">';
        echo '<p>';
        echo '<span>UID: </span>' . $row['uid'];
        echo '</p>';
        echo '<p>';
        echo '<span>First Name: </span>' . $row['firstName'];
        echo '</p>';
        echo '<p>';
        echo '<span>Last Name: </span>' . $row['lastName'];
        echo '</p>';
        echo '<p>';
        echo '<span>Birthday: </span>' . $row['birthDay'];
        echo '</p>';
        echo '<p>';
        echo '<span>Date change: </span>'.$row['dateChange'];
        echo '</p>';
        echo '<p>';
        echo '<span>description: </span>' . $row['description'];
        echo '</p>';
        echo '</div>';
    }
}
?>
</body>
