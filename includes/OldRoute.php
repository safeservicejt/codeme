<?php

class OldRoute
{

    public static $listRouteNames = array();

    public static $listPatternNames = array();
    public static $listPatternValues = array();


    public function get($routeName = 'page-not-found', $controllerName, $filter = array())
    {
        $varObject = '';

        if (is_object($controllerName)) {

            (object)$varObject = $controllerName;

            $controllerName = '';
        }

        self::$listRouteNames[$routeName] = $controllerName;

        $varName = isset($_GET['load']) ? trim($_GET['load']) : '';

        $listVarNames = explode('/', $varName);

        $totalVarName = count($listVarNames);

        if (($totalVarName == 1 || $listVarNames[1] == '') && $listVarNames[0] == $routeName) {

            if (is_object($varObject)) {

                self::loadObject($varObject);
            }

            self::loadController($controllerName);

            die();
        }

        $listRouteName = explode('/', $routeName);

        $totalRouteName = count($listRouteName);

//        Not use pattern

        if (count(self::$listPatternNames) == 0) {


            if ($totalVarName < $totalRouteName) {
                self::$listPatternNames = array();
                return false;
            }

//                Load: test    Route: test2
            if ($listRouteName[0] != $listVarNames[0]) {
                self::$listPatternNames = array();
                return false;
            }

            $funcName = '';

            if (!preg_match('/(\w+)\@(\w+)/i', $controllerName)) {

                $funcName = 'get' . ucwords($listVarNames[1]);

                if (preg_match('/(\w+)\-(\w+)/i', $listVarNames[1], $matchesFuncName)) {
                    $funcName = 'get' . ucwords($matchesFuncName[1]) . ucwords($matchesFuncName[2]);
                }
            }

            if (is_object($varObject)) {

                self::loadObject($varObject);
            }

            self::loadController($controllerName, $funcName);

            die();
        }


        //Start check pattern
        if (count(self::$listPatternNames) > 0) {

            if ($totalVarName < $totalRouteName) {
                self::$listPatternNames = array();
                return false;
            }


            for ($i = 0; $i < $totalRouteName; $i++) {
                $valueRouteName = $listRouteName[$i];

                if (preg_match('/\{(\w+)\}/i', $valueRouteName, $matchesValue)) {


                    if (!preg_match('/^' . self::$listPatternNames[$matchesValue[1]] . '$/i', $listVarNames[$i])) {

                        self::$listPatternNames = array();
                        return false;
                    }


                } else {
                    if ($valueRouteName != $listVarNames[$i]) {
                        self::$listPatternNames = array();

                        return false;
                    }


                }


            }

            self::$listPatternNames = array();

            if (is_object($varObject)) {

                self::loadObject($varObject);
            }

            self::loadController($controllerName);

            die();

        }


    }

    public function loadObject($varObject)
    {
        $varObject();

        Cache::saveCache();

        die();

    }

    public function loadController($controllerName = '', $funcName = '')
    {
//        Cache::loadCache();

        Controller::load($controllerName, $funcName);

        Cache::saveCache();
    }

    public function pattern($patternName, $patternValue)
    {
        self::$listPatternNames[$patternName] = $patternValue;
    }


    public function alert($str = '')
    {
        ob_end_clean();

        die($str);

    }


}

?>