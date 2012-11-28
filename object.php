<?php
function addToList($array, $string, $operation){
        $temp = $array[$string];
        echo $temp;
        if($temp == NULL){
            $array[$string] = $operation;
            echo "here";
        }
        else{
            array_push($temp, $operation);
            $temp = array_unique($temp);
            $array[$string] = $temp;
        }
        return $array;
    }
    
    $test = array(
        "hello" => array("funcn1", "fun"),
        "hello1" => array("funcn2"),
        "hello2" => array("funcn3"),
    );
    $test = addToList($test, "hello", "fun");
    print_r($test);
?>