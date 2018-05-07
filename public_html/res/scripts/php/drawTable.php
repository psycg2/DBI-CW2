<?php
/**
 * Created by PhpStorm.
 * User: callu
 * Date: 06/05/2018
 * Time: 03:05
 */

function draw_table($column_names, $entries, $inputs, $search) {

    echo "<form method='post' id='addForm'></form><form method='post' id='editForm'></form><form method='post' id='searchForm'></form><table><tr>";
    foreach ($column_names as $column_name) {
        echo "<th>{$column_name}</th>";
    }
    echo "</tr><tr><td><input form='searchForm' name='id' type='number' value='".($search?$search[0]:"")."' min='0'> </td>";
    $i=1;
    foreach ($inputs as $input) {
        echo "<td>".str_replace("addForm'", "searchForm'  value='".($search?$search[$i]:"")."'", $input)."</td>";
        $i++;
    }
    echo "<td><input id='searchSub' form='searchForm' name='search' type='submit' value='🔍'></td></tr>";

    $y = 0;
    foreach ($entries as $entry) {
        $valid = true;
        $x=0;
        foreach ($entry as $value) {
            if($search) {
                if ($search[$x]) {
                    if (!(strpos($value, $search[$x]) !== false) && $value !== $search[$x]) {
                        $valid = false;
                    }
                }
            }
            $x++;
        }
        if($valid) {
            echo "<tr>";
            $x = 0;
            foreach ($entry as $value) {
                echo "<td id='cell{$x},{$y}' onclick='edit({$x},{$y})'>{$value}</td>";
                $x++;
            }
            echo "<td>
            <form method='post'>
                <input type='submit' name='remove{$entry[0]}' value='×'/>
            </form>
        </td></tr>";
        }
        $y++;
    }
    echo "<tr><td></td>";
    foreach ($inputs as $input) {
        echo "<td>{$input}</td>";
    }
    echo "<td><input form='addForm' name='add' type='submit' value='+'></td></tr></table>";
}