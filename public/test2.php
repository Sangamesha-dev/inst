<?php
for($i=1;$i<=100;$i++){
    $divThree = $i / 3;
    $divFive = $i/5;
    $print = $i;
    if(!is_float($divThree) && !is_float($divFive)){
        $print = 'HollyMolly';
    }
    if(!is_float($divThree)){
        $print = 'Holly';
    }
    if(!is_float($divThree)){
        $print = 'Molly';
    }
    echo $print;
}
