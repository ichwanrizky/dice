


<form method="POST">

    <input type="hidden" name="simpan" value="1">

    <table border="0">
        <tr>
            <td width="150">Number of Player</td>
            <td>: <input type="number" min="1" name="num_player" required></td>
        </tr>
        <tr>
            <td width="150">Number of Dice</td>
            <td>: <input type="number" min="1" name="num_dice" required></td>
        </tr>
    </table>
    <button type="submit">Play</button>
</form> <br>

<?php

    if(@$_POST["simpan"] == 1){
        
        echo "Player = " . @$_POST["num_player"] . ", Dice = " . @$_POST["num_dice"] . "<br><br>";

        $x = 1;

        $next_game = 1;
        $player_has_dice = "";
        $end_score = [];

        do {

            $turn = 0;

            echo "==================== <br>";
            echo "Turn " . $x . " roll the dice : <br>";

            for($i=1; $i<=@$_POST["num_player"]; $i++){

                if($x == 1){
                    $score[$i] = 0;
                    $jum_dice = @$_POST["num_dice"];
                }

                else{
                    $jum_dice = sizeof( $arr_dice2[$i] );
                }
    
                $arr_dice[$i] = [];
                $arr_dice2[$i] = [];

    
                for($j=1; $j<=$jum_dice; $j++){
                    array_push($arr_dice[$i], rand(1,6));
                }

                echo "Player #" .$i ." (".$score[$i]."): " . implode(",", $arr_dice[$i]) .  "<br>";

                for($n=0; $n<sizeof($arr_dice[$i]); $n++){

                    if( $arr_dice[$i][$n] == "6" ){
                        $score[$i] += 1;
                    }

                    else{
                        if( $arr_dice[$i][$n] <> "1" ){
                            array_push($arr_dice2[$i], $arr_dice[$i][$n]);
                        }
                    }

                }

                // print_r($arr_dice[$i]);
                // echo "<br>";


            }

            for($i=1; $i<=@$_POST["num_player"]; $i++){

                for($n=0; $n<sizeof($arr_dice[$i]); $n++){
                    if( $arr_dice[$i][$n] == "1" ){
                        if($i==@$_POST["num_player"]) $next_index = 1;
                        else $next_index = $i+1;

                        array_push($arr_dice2[$next_index], 1);
                    }
                }
            }
            
            echo "<br>After Evaluation : <br>";
            
            for($i=1; $i<=@$_POST["num_player"]; $i++){
                
                if(sizeof($arr_dice2[$i]) > 0){
                    $turn += 1;
                    echo "Player #" .$i ." (".$score[$i]."): " . implode(",", $arr_dice2[$i]) .  "<br>";

                    $player_has_dice = $i;
                }

                else{
                    echo "Player #" .$i ." (".$score[$i]."): _ (Stop playing because it has no dice) <br>";
                }

            }

            if($turn > 1) $next_game += 1;
            else{
                echo "==================== <br>";
                if($player_has_dice == "") echo "Game ends because no player has dice.";
                else echo "Game ends because only player #".$player_has_dice." has dice. ";
                echo "<br>";

                for($i=1; $i<=@$_POST["num_player"]; $i++){
                    array_push($end_score, $score[$i]);
                }

                $winner = [];
                $maxs = array_keys($end_score, max($end_score));
                for($i=0; $i<sizeof($maxs); $i++){
                    array_push($winner, ($maxs[$i] + 1));
                }

                if(sizeof($maxs) == @$_POST["num_player"]) echo "Game draw.";
                else echo "Game won by player #(".implode(",", $winner).") because it has more points than other players";

            }

            // echo $next_game;
            echo "<br><br>";
            
            $x++;

        } while ($x <= $next_game);

       
        
    }


?>