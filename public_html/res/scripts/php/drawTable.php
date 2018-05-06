<?php
/**
 * Created by PhpStorm.
 * User: callu
 * Date: 06/05/2018
 * Time: 03:05
 */

function draw_table($column_names, $entries) {
    echo "<form method='post' id='addForm'></form><table><tr>";
    foreach ($column_names as $column_name) {
        echo "<th>{$column_name}</th>";
    }
    echo "</tr>";
    foreach ($entries as $entry) {
        echo "<tr>";
        foreach ($entry as $value) {
            echo "<td>{$value}</td>";
        }
        echo "<td>
            <form method='post'>
                <input type='submit' name='remove{$entry[0]}' value='×'/>
            </form>
        </td></tr>";
    }
    echo "<tr><td></td>";
    for ($i = 0; $i < sizeof($entry)-1; $i++){
        echo "<td><input name='data{$i}' form='addForm'></td>";
    }
    echo "<td><input form='addForm' name='add' type='submit' value='+'></td></tr></table>";
}