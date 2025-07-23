<?php

function tibcal_shortcode() {
    ob_start(); // Start capturing output
    ?>
    <h1>Tibetan to Gregorian Calendar Converter</h1>
    <?php
    /*
      Initialize arrays for the Animals and Elements.
      These just make it convenient to display the form elements in FOR loops
      (see Display the Form, below)
    */

    $pagepath = explode('?', $_SERVER['REQUEST_URI'])[0];
    $imgpath = '/wp-content/themes/mandala-kadence/tibcal/tibletters/';
    $animals_english = array("Hare","Dragon","Snake","Horse",
        "Sheep","Monkey","Bird","Dog","Pig","Rat","Ox","Tiger");
    $animals_phonetic = array("y&ouml;","druk","tr&uuml;","ta",
        "luk","tre","ja","khyi","pak","tsi","lang","tak");
    $animals_wylie = array("yos","'brug","sbrul","rta",
        "lug","spre","bya","khyi","phag","tsi","glang","stag");

    $elements_english = array("Fire","Earth","Iron","Water","Wood");
    $elements_phonetic = array("me","sa","chak","chu","shing");
    $elements_wylie = array("me","sa","lcags","chu","zhing");

    ?>

        <style>
            .calgrid {
                display: grid;
                grid-template-columns: 1fr 1fr;     /* Two columns */
                grid-template-rows: repeat(2, 1fr); /* Two equal-height rows */
                gap: 10px;
                height: 400px; /* Set desired total height */
                margin-bottom: 2rem;
            }

            .item {
                padding: 20px;
                text-align: center;
                border: thin solid #555;
            }

            .animals {
                grid-row: span 2; /* Span both rows (twice the height) */
            }

            .after-text {
                margin-top: 10rem;
            }

            .results {
                border: thin solid #777;
                padding: 1rem;
                background-color: aliceblue;
                margin-bottom: 1.5rem;
            }
        </style>
    <!--table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
            <td width="25%"-->

                <?php
                /*
                  Three pieces of information are received as user input:
                    ANIMAL (required)
                    ELEMENT (required)
                    CYCLE (optional-- if omitted, all possible rabjung cycles are displayed)
                  If either ANIMAL or ELEMENT are blank, the request is malformed and just the basic
                  form is displayed.
                */
                $animal = isset($_REQUEST['animal'])? $_REQUEST['animal'] : null;
                $element = isset($_REQUEST['element'])?$_REQUEST['element'] : null;
                $cycle= isset($_REQUEST['cycle'])? $_REQUEST['cycle'] : null;

                /*
                  The variable '$results' will contain the form processing results, if any.
                */
                $results = '';
                /*
                  Both $animal and $element are required fields, so we assume if they are set then we are
                  getting a request from the form and we need to process the request.
                */
                if( isset($animal) && isset($element) ) {
                    // Here is the heart of the algorithm. It's quite simple.
                    if( ((2 * $element) >= $animal) && ($animal % 2 == 0) )
                        $j = 1;
                    else if( ((2 * $element) < $animal) && ($animal % 2 == 0) )
                        $j = 61;
                    else if( ((2 * $element) > $animal) && ($animal % 2 > 0) )
                        $j = -5;
                    else if( ($element == 0) && ($animal == 11) )
                        $j = 115;
                    else $j = 55;
                    $year_of_cycle = (12 * $element) - (5 * $animal) + $j;

                    $results .= "<h2>Results</h2>\n";
                    if( isset($cycle) && ($cycle > 0) ){
                        $year_ce = $year_of_cycle + (60 * $cycle) + 966;
                        $results .= "The Tibetan <b>$elements_english[$element] $animals_english[$animal]</b> year of the " .
                            $cycle;
                        switch( $cycle ){
                            case 1:  $results .= "<sup>st</sup>"; break;
                            case 2:  $results .= "<sup>nd</sup>"; break;
                            case 3:  $results .= "<sup>rd</sup>"; break;
                            default: $results .= "<sup>th</sup>";
                        }
                        $results .= " Rabjung corresponds to " .
                            "<b>" . $year_ce . "-" . ($year_ce + 1) . "</b>" .
                            " of the Common Era.";
                    }
                    else {
                        $results .= "The Tibetan <b>$elements_english[$element] $animals_english[$animal]</b> year " .
                            "corresponds to the following Common Era years:<br>\n";
                        $results .= "<table border='0'>\n";
                        $results .= "<tr valign='top'>\n<td>";
                        for( $i=1; $i<19; ++$i ){
                            if( (($i-1) % 9) == 0 )
                                $results .= "</td>\n<td width='10'></td>\n<td>\n";
                            $year_ce = $year_of_cycle + (60 * $i) + 966;
                            $results .= "&nbsp;&nbsp;$year_ce-" . ($year_ce + 1) . " <span class='s11'>(" .
                                $i;
                            switch( $i ){
                                case 1:  $results .= "<sup>st</sup>"; break;
                                case 2:  $results .= "<sup>nd</sup>"; break;
                                case 3:  $results .= "<sup>rd</sup>"; break;
                                default: $results .= "<sup>th</sup>";
                            }
                            $results .= " Rabjung)</span><br>";
                        }
                        $results .= "</td>\n</tr>\n</table>\n";
                    }
                }
                ?>
                <?php
                //If there are results from the form processing, display them in a grey box.
                if( $results ) {
                    ?>
                    <div class="results"><?= $results ?></div>
                    <?php
                }
                //Then, display the form...
                ?>

                <!--div>Path is: <?= $pagepath ?></div -->


                <div>
                    <p> Convert Tibetan calendar years into their Western (<i>Common Era</i>
                        or <i>A.D.</i>) equivalents.</p>
                    <!-- Display the Form -->
                    <form action="<?= $pagepath ?>" class="calgrid">
                        <!--div style="border:1px solid black;float:left;padding:3px 3px 3px 3px;width:325px;" -->
                        <div class="item animals">
                                <h2>1. Select an Animal</h2>
                                <table class="tibcal" border="0" cellpadding="0">
                                    <tr><th></th><th>&nbsp;English&nbsp;</th><th>&nbsp;Tibetan&nbsp;</th>
                                        <th>&nbsp;Phonetic&nbsp;</th><th>&nbsp;Wylie&nbsp;</th></tr>
                                    <?php
                                    for( $i=0; $i<count($animals_english); ++$i ){
                                        echo "<tr>\n";
                                        echo "	<td><input type='radio' name='animal' value='$i' ";
                                        if( isset($animal) ){
                                            if( ($animal == $i) )
                                                echo "checked";
                                        }
                                        else
                                            if( $i == 0 ) echo "checked";
                                        echo "></td>\n";
                                        echo "<td>$animals_english[$i]</td>\n";
                                        echo "<td align='center'><img src='" . $imgpath .
                                            str_replace("'","_",$animals_wylie[$i]) . ".gif'></td>\n";
                                        echo "<td align='center'>$animals_phonetic[$i]</td>\n";
                                        echo "<td align='center'>$animals_wylie[$i]</td>\n";
                                        echo "</tr>\n";
                                    }
                                    ?>
                                </table>
                        </div>

                        <!--div style="float:left;width:325px;" -->
                        <div class="item elements">
                            <h2>2. Select an Element</h2>
                            <table class="tibcal" border="0" cellpadding="0">
                                <th></th><th>&nbsp;English&nbsp;</th><th>&nbsp;Tibetan&nbsp;</th>
                                <th>&nbsp;Phonetic&nbsp;</th><th>&nbsp;Wylie&nbsp;</th>
                                <?php
                                for( $i=0; $i<count($elements_english); ++$i ){
                                    echo "<tr>\n";
                                    echo "	<td><input type='radio' name='element' value='$i' ";
                                    if( isset($element) ){
                                        if( ($element == $i) )
                                            echo "checked";
                                    }
                                    else
                                        if( $i == 0 ) echo "checked";
                                    echo "></td>\n";
                                    echo "<td>$elements_english[$i]</td>\n";
                                    echo "<td align='center'><img src='" . $imgpath .
                                        str_replace("'","_",$elements_wylie[$i]) . ".gif'></td>\n";
                                    echo "<td align='center'>$elements_phonetic[$i]</td>\n";
                                    echo "<td align='center'>$elements_wylie[$i]</td>\n";
                                    echo "</tr>\n";
                                }
                                ?>
                            </table>
                        </div>
                        <!--div style="border:1px solid black;padding:3px 3px 3px 3px;" -->
                        <div class="item rabjung">
                            <h2>3. Select a Rabjung Cycle</h2>
                            <table class="tibcal" width="100%" border="0">
                                <tr><td>
                                        <select name="cycle">
                                            <?php
                                            //Show rabjung cycles up to the 18th rabjung, which begins in 2047
                                            for( $i=0; $i<19; ++$i ){
                                                echo "<option value=$i ";
                                                if( isset($cycle) ){
                                                    if( $cycle == $i ) echo "selected";
                                                }
                                                else if( $i==0 )
                                                    echo "selected";
                                                echo ">";
                                                if( $i == 0 )
                                                    echo "Unknown";
                                                else {
                                                    echo "$i (" . (967 + (60*$i)) . " - " . (967 + (60*$i) + 60) . " C.E.)";
                                                }
                                                echo "</option>\n";
                                            }
                                            ?>
                                        </select>
                                    </td></tr>
                                <caption align="left" valign="bottom">If "Unknown", a set of possible Western years will be returned.</caption>
                            </table>
                            <p>
                                <input type="submit" value="Convert" />
                                <input type="reset"  value="Reset" onClick="window.location.href='<?= $pagepath ?>';" />
                        </div>
                    </form>


                    <div class="after-text">
                        <div style="width:auto;">
                            <a name="details"></a>
                            <h2>The Details</h2>
                            <p>
                                A Tibetan year is properly identified by three parts. The first two,
                                the <b>Animal</b> and <b>Element</b>, correspond roughly to similar identifiers used in the Chinese calendar.
                                The third part is the <b>Rabjung</b>
                                (<i>rab byung</i>, <img style="display:inline;" src="<?php echo $imgpath; ?>rab_byung.gif" alt="rab byung" hspace="0" vspace="0" align="middle">).
                                The Rabjung are 60-year cycles, the first of which began in 1027 C.E.
                                We are currently in the
                                17th Rabjung, which began on February 28, 1987.</p>

                            <p>
                                Unfortunately, pre-modern Tibetan literature doesn't always identify dates with all three of these
                                parts &#151; often only the animal and element are explicitly mentioned (and sometimes not
                                even these are given). However, if
                                you can narrow the author's dates to within a century or so, then it's not hard to
                                figure out the rabjung for yourself.</p>

                            <p>
                                Each year of a Rabjung cycle spans two Western years. This is because the Tibetan New Year
                                or Losar (<i>lo gsar</i>,
                                <img style="display:inline;" src="<?php echo $imgpath; ?>lo_gsar.gif" alt="lo gsar" hspace="0" vspace="0" align="middle">)
                                falls in either February or March.
                                You will find a table of Tibetan New Years from 1880 to 1997 in Philippe Cornu's
                                <i><a target="_blank"
                                      href="http://www.amazon.com/exec/obidos/ASIN/1570622175/qid=1021759117/sr=1-1/ref=sr_1_1/103-7871113-3823018">Tibetan Astrology</a></i>
                                (Boston: Shambhala, 1997), pp. 157-170.</p>

                            <p>
                                This calculator is based on an algorithm published by Peter Meyer at
                                <a target="_blank" href="https://www.hermetic.ch/cal_stud/tib_year.htm">https://www.hermetic.ch/cal_stud/tib_year.htm</a>.
                            </p>
                            <p>
                                For more in-depth information about the Tibetan calendar, see
                                <a target="_blank" href="https://nitartha.org/about-the-tibetan-calendar/">
                                    http://www.nitartha.org/calendar_overview.html</a>.
                            </p>
                        </div>
                    </div>
                </div>
    <?php
        return ob_get_clean(); // Return the captured output
}

add_shortcode('tibcal', 'tibcal_shortcode');