<html>
<head>
    <title>CD Catalogue</title>
    <link rel="stylesheet" href="res/style/style.css"/>

</head>
<?php include "res/frags/header.php";

$stmt = query($catalogue->conn,"SELECT COUNT(*) as count FROM artist;", null, null);
$artist_count = mysqli_fetch_object($stmt->get_result())->count;

$stmt = query($catalogue->conn,"SELECT COUNT(*) as count FROM cd;", null, null);
$cd_count = mysqli_fetch_object($stmt->get_result())->count;

$stmt = query($catalogue->conn,"SELECT COUNT(*) as count FROM track;", null, null);
$track_count = mysqli_fetch_object($stmt->get_result())->count;

?>

<div class="centerBlock">
    <h1>Database metrics</h1>
    <table>
        <tr>
            <th>Table</th>
            <th>No. of entries</th>
        </tr>
        <tr>
            <td>Artists</td>
            <td><?=$artist_count?></td>
        </tr>
        <tr>
            <td>CDs</td>
            <td><?=$cd_count?></td>
        </tr>
        <tr>
            <td>Tracks</td>
            <td><?=$track_count?></td>
        </tr>

    </table>
</div>

</html>
