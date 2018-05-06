<?php
/**
 * Created by PhpStorm.
 * User: callu
 * Date: 06/05/2018
 * Time: 02:30
 */
include "res/scripts/php/drawTable.php";
include "res/scripts/php/dataStructure.php";
$catalogue = new Catalogue();


$page = basename($_SERVER["PHP_SELF"], ".php");

foreach($catalogue->{$page}->{$page} as $entry){
    if(array_key_exists('remove'.$entry->id,$_POST)){
        $catalogue->{$page}->remove($entry->id);
    }
}

if(array_key_exists('add',$_POST)){
    $values = array();
    $index = 0;
    while(array_key_exists('data'.$index, $_POST)){
        array_push($values, $_POST['data'.$index]);
        $index++;
    }
}



?>
<header>
    <h1>CD Catalogue</h1>
    <nav>
        <ul id="navBar">
            <li><a <?=($page == "index"? "class='active'" : "")?> href="index.php">Home</a></li>
            <li><a <?=($page == "artists"? "class='active'" : "")?> href="artists.php">Artists</a></li>
            <li><a <?=($page == "cds"? "class='active'" : "")?> href="cds.php">CDs</a></li>
            <li><a <?=($page == "tracks"? "class='active'" : "")?> href="tracks.php">Tracks</a></li>
        </ul>
    </nav>

</header>