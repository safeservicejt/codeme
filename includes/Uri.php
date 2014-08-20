<?php

class Uri
{

    public function getNext($uriName)
    {
        $uri = explode('/', $_GET['load']);

        if (isset($uriName[1])) {

            $position = array_search($uriName, $uri);

            $position++;

            if (isset($uri[$position])) {
                return $uri[$position];
            } else {
                return false;
            }

        } else {
            return false;
        }

    }


}

?>