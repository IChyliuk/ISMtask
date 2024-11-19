<?php

global $conn;
include_once('db.php');
include_once('model.php');
include_once('test.php');
include_once('config.php');

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User transactions information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>User transactions information</h1>
<form action="data.php" method="get">
    <label for="user">Select user:</label>
    <select name="user" id="user">
        <?php
        $users = get_users($conn);
        foreach ($users as $user) {
            echo "<option value=" . $user['user_id'] . ">" . $user["user_name"] . "</option>";
        }
        ?>
    </select>
    <input id="submit" type="submit" value="Show">
</form>

<div id="data">
    <h2>Transactions of `<?php $user['user_id'] ?>`</h2>
    <table>
        <tr>
            <th>Month</th>
            <th>Amount</th>
        </tr>
        <tbody id="tbody">

        </tbody>
    </table>
</div>
<script src="script.js"></script>
</body>
</html>
