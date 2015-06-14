<?php

function import($conn,$fileName = 'db.sql')
{

    if (file_exists($fileName)) {

        $conn->query("SET NAMES 'utf8';");


        $query = file_get_contents($fileName);

        preg_match_all('/CREATE.*?\;\n/is', $query, $creates);

        $total = count($creates[0]);

        for ($i = 0; $i < $total; $i++) {

            $conn->query($creates[0][$i]);
        }

        preg_match_all('/INSERT.*?\;\n/is', $query, $creates);

        $total = count($creates[0]);

        for ($i = 0; $i < $total; $i++) {

            $conn->query($creates[0][$i]);
        }

    }

    return false;

}

?>