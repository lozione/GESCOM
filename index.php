<?php 
require 'config.php';

?>    
<html>
	<head>
		<title></title>
		<style type="text/css">
        table.cal_oriz{
            text-align:center;
            border-collapse: collapse;
            position: relative;
            width: 100%;
            background-color: white;
            border:1px solid #053E85;
        }
        table.cal_oriz tr {
            border-bottom:1px solid #053E85;
        }
        table.cal_oriz td {
            padding:1px;
        }
        table.cal_oriz td.dom{
            background-color:red;
            border:1px solid #053E85;            
                color: #FFF;
        }
        table.cal_oriz td.sab{
            background-color: lightpink;
            border:1px solid #053E85;
        }
        table.cal_oriz td.oggi{
            border:2px solid #053E85;
            font-weight:bold;
        }
        input.text {
            vertical-align: middle;
            text-align: center;
           
        }
        /*
          text-align:center;
            border-collapse: collapse;
            top:0;
            left:0;
            width: 100%;
            background-color: white;
            border:2px solid #053E85;
        */
    </style>
	</head>
	<body>
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Mese: <select name="mese" required>
        <?php
            $mese = array(1 => 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
            
            for($a=1; $a<=12; $a++)
            {
                echo "<option value='$a'>$mese[$a]</option>\n";
            }
        ?>
         </select>
    Anno:
    <input type="text" size="4" maxlength="4" name="anno" required>

    <input type="submit" value="Calcola mese"/>
     </form>   
	<?php
    if (isset($_POST['mese']) && isset($_POST['anno'])) {     
    $month = $_POST['mese'];
    $year = $_POST['anno'];
    echo $mese[$month] . "/" . $year;
        
    
    $oggi = date("d");
    
    
    $giorni_settimana = array(1, "L", "M", "M", "G", "V", "S", "D");
    $mese = array('Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
    $time_primo_del_mese = mktime(0, 0, 0, $month, 1, $year);
    $primo_del_mese = date('w', $time_primo_del_mese);
    $giorni_nel_mese = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    echo "<p>" . $mese[($month - 1)] . "</p>";
    echo "<table class='cal_oriz' cellspacing='0' cellpadding='0'>" . "\n";
    echo "<tr>" . "\n";
    $g = $primo_del_mese;
    // correzione baco
    if ($g==0) {
        $g=1;
    }
    // fine correzione baco
    echo "<td colspan='2'>" . "\n";
    echo " commessa | Localita ";
    echo "</td>" . "\n";
    for ($i = 1; $i <= $giorni_nel_mese; $i++) {
        $classe = "";
        if ($giorni_settimana[$g] == "D") {
            $classe = " class='dom'";
        } elseif ($giorni_settimana[$g] == "S") {
            $classe = " class='sab'";
        }
        echo "<td $classe>" . $giorni_settimana[$g] . "</td>" . "\n";
        if ($g == 7) {
            $g = 1;
        } else {
            $g++;
        }
    }
    echo "</tr>" . "\n";
    echo "<tr>" . "\n";
    echo "<td colspan='2'>" . "\n";
    echo "</td>" . "\n";
    for ($i = 1; $i <= $giorni_nel_mese; $i++) {
        echo "<td>$i</td>". "\n";
    }
    echo "</tr>" . "\n";
    $righe = R::findAll('commesse_tip');
    foreach($righe as $riga){
        echo "<tr>" . "\n";
        echo "<td>". "\n";
        echo "<select name='commesse' required>" . "\n";
        $commesse = R::findAll('commesse_tip');
        foreach($commesse as $commessa){
            echo "<option value='".$commessa->id."'>" . $commessa->descrizione_commessa."</option>" . "\n";
        }
        echo "</select>" . "\n";
        echo "</td>" . "\n";
        $localita = R::findAll('localita_tip');
        echo "<td>". "\n";
        echo "<select name='localita' required>" . "\n";
        foreach($localita as $loc){
            echo "<option value='".$loc->id."'>" .$loc->nome_localita. "</option>" . "\n";
        }
        echo "</select>" . "\n";
        echo "</td>" . "\n";
        for ($i = 1; $i <= $giorni_nel_mese; $i++) {
            echo "<td ><input type='text' name='$i' size='1' maxlength='3' class='text' /></td>" . "\n";
        }	
        echo "</tr>" . "\n";
    }
    echo "</table>" . "\n";
    }
    ?>
</body>
</html>