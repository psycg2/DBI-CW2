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
if($page != "index") {
    $search = array();

    foreach ($catalogue->{$page}->{$page} as $entry) {
        if (array_key_exists('remove' . $entry->id, $_POST)) {
            $catalogue->{$page}->remove($entry->id);
        }
    }

    foreach ($catalogue->{$page}->{$page} as $entry) {
        for ($i = 0; $i < sizeof($catalogue->{$page}->inputs); $i++) {
            if (array_key_exists("data{$i},{$entry->id}", $_POST)) {
                $catalogue->{$page}->update($entry->id, $i, $_POST["data{$i},{$entry->id}"]);
            }
        }
    }

    if (array_key_exists('add', $_POST)) {
        $values = array();
        $index = 0;
        while (array_key_exists('data' . $index, $_POST)) {
            array_push($values, $_POST['data' . $index]);
            $index++;
        }
        $catalogue->{$page}->insert($values);
    }

    if (array_key_exists('search', $_POST)) {
        array_push($search, $_POST["id"]);
        $index = 0;
        while (array_key_exists('data' . $index, $_POST)) {
            if (strpos($catalogue->{$page}->inputs[$index], "select") !== false) {
                switch ($page) {
                    case "cds":
                        array_push($search, is_numeric($_POST['data' . $index] < 0) ? $catalogue->artists->get_by_id($_POST['data' . $index])->name : "");
                        break;
                    case "tracks":
                        array_push($search, is_numeric($_POST['data' . $index] < 0) ? $catalogue->cds->get_by_id($_POST['data' . $index])->title : "");
                        break;
                }
            } else {
                array_push($search, $_POST['data' . $index]);
            }
            $index++;
        }
    }

    $inputs = "<script> let inputs=[";
    foreach ($catalogue->{$page}->inputs as $input) {
        $inputs .= '"' . $input . '", ';
    }
    $inputs = substr($inputs, 0, -2) . "];</script> ";
    echo $inputs;
}
?>
    <script src="res/scripts/js/script.js"></script>
    <header>
        <h1>CD Catalogue</h1>
        <nav>
            <ul id="navBar">
                <li><a <?= ($page == "index" ? "class='active'" : "") ?> href="index.php">Home</a></li>
                <li><a <?= ($page == "artists" ? "class='active'" : "") ?> href="artists.php">Artists</a></li>
                <li><a <?= ($page == "cds" ? "class='active'" : "") ?> href="cds.php">CDs</a></li>
                <li><a <?= ($page == "tracks" ? "class='active'" : "") ?> href="tracks.php">Tracks</a></li>
            </ul>
        </nav>

    </header>

<?php
if($page!="index") {
    $catalogue->{$page}->table($search);
}
?>