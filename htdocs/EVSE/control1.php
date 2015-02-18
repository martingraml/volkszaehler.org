<?php
$timestamp = time();
header("Content-Type: text/html; charset=utf-8");
$filepath='/run/values';
$device='/dev/ttyUSB1';

$values=array(
             '1.7.0(' => 0,
             '2.7.0(' => 0,
             '1.8.0(' => 0,
             '2.8.0(' => 0,
             '31.7(' => 0,
             '51.7(' => 0,
             '71.7(' => 0,
             '81.7.4(' => 180,
             '81.7.15(' => 180,
             '81.7.26(' => 180,
             );

$description=array(
             '1.7.0(' => 'Leistung Bezug: ',
             '2.7.0(' => 'Leistung Einspeisung: ',
             '1.8.0(' => 'Zählerstand Bezug: ',
             '2.8.0(' => 'Zählerstand Einspeisung: ',
             '31.7(' => 'Strom P1: ',
             '51.7(' => 'Strom P2: ',
             '71.7(' => 'Strom P3: ',
             '81.7.4(' => 'Phase P1: ',
             '81.7.15(' => 'Phase P2: ',
             '81.7.26(' => 'Phase P3: ',
             );

error_reporting(E_ALL);

function readValuesFromFile() {
  global $filepath;
  if (file_exists($filepath)) {
    return unserialize( file_get_contents( $filepath ) );
  } else {
    echo "Die Datei $filename existiert nicht";
  }
  return NULL;
}

//Werte Lesen einlesen
//echo getcwd() . "\n";
$tmpvalues = readValuesFromFile();
foreach(array_keys($values) as $orbis) {
  if(key_exists($orbis, $tmpvalues)){
    $values[$orbis]=$tmpvalues[$orbis];
  }
}

$status = json_decode(file_get_contents("/run/status.json"), true);
$auto = $status['Automatik'];
$text1 = "";
//print_r($_POST);
if(isset($_POST['formSubmit'])) {
  $aControl = $_POST['formControl'];
  if(!isset($aControl) || ($aControl == "-")) {
    $text1 = "<p>Du hast nichts ausgewählt!</p>\n";
  } else {
    $text1 = "<p>Ausgewählt wurde $aControl</p>\n";
    if($aControl == "SC") {
      $curr = $_POST['curr'];
      if(isset($curr)) {
        $aControl = $aControl . " " . $curr;
      }
    }
    $status['Befehl'] = $status['Befehl'] . $aControl . ";";
  }
  $auto = $_POST['auto'];
  if(!isset($auto)) {
    $status['Automatik'] = "Nein";
  } else {
    $status['Automatik'] = "Ja";
  }
  $stop = $_POST['stop'];
  if(isset($stop)) {
    $status['Stopzeit'] = $timestamp + ($_POST['stophr']*60 + $_POST['stopmin'] )*60;
  }
  $start = $_POST['start'];
  if(isset($start)) {
    $status['Startzeit'] = $timestamp + ($_POST['starthr']*60 + $_POST['startmin'] )*60;
  }
  $tmp =  file_put_contents("/run/status.json", json_encode($status), LOCK_EX);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/l$
<html>
<head>
        <title>Steuerung Elektrotankstelle</title>
<!-- define some style elements-->
<style>
label,a
{
        font-family : Arial, Helvetica, sans-serif;
        font-size : 14px;
}

</style>

</head>

<body background="hgnew.jpg">
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="../jsplot/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="../jsplot/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="../jsplot/jquery.jqplot.css" />

<style type="text/css">

.plot {
    margin-bottom: 30px;
    margin-left: auto;
    margin-right: auto;
}

#chart4 .jqplot-meterGauge-tick, #chart4 .jqplot-meterGauge-label {
    font-size: 12pt;
}
</style>

<div id="chart4" class="plot" style="width:500px;height:300px;"></div>

<script type="text/javascript" src="../jsplot/plugins/jqplot.meterGaugeRenderer.js"></script>
<hr>
<? global $timestamp; echo date("d.m.Y H:i", $timestamp);?>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <label for='formControl'>Wähle den Befehl aus</label><br>
        <select name="formControl">
                <option value="-">...</option>
                <option value="GC">Strom (Min/Max)</option>
                <option value="GE">Aktueller Strom</option>
                <option value="SC">Setze Strom</option>
                <option value="GS">Aktueller Status</option>
                <option value="FE">Start Ladung</option>
                <option value="FS">Stopp Ladung</option>
                <option value="ST starthr startmin endhr endmin">Setze Timer</option>
                <option value="ST 0 0 0 0">Reset Timer</option>
                <option value="GT">Aktuelle Zeit</option>
                <option value="S1">Setze Zeit</option>
                <option value="FR">Reset EVSE</option>
        </select>
        <input type="checkbox" name="auto" <? global $status; if($status['Automatik'] == "Ja") echo "checked"?>>Automatikbetrieb<br>
          <table border="0" cellpadding="5" cellspacing="0" bgcolor="#E0E0E0">
          <tr>
            <td>&nbsp;</td>
            <td align="right">Vorgabestrom</td>
            <td><input name="curr" type="number" size="2" max="16" min="6" value="<? global $status; echo $status['GE']?>"></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="start"><br></td>
            <td align="right">Start in Stunden:Minuten</td>
            <td><input name="starthr" type="number" size="2" max="100" min="0" value="0"></td>
            <td><input name="startmin" type="number" size="2" max="59" min="0" value="0"></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="stop"><br></td>
            <td align="right">Stop in Stunden:Minuten</td>
            <td><input name="stophr" type="number" size="2" max="100" min="0" value="0"></td>
            <td><input name="stopmin" type="number" size="2" max="59" min="0" value="0"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right" valign="top">Kommentar:</td>
            <th colspan="4" align="left"><textarea name="Text" rows="2" cols="50"></textarea></th>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Formular:</td>
            <td>
            <input type="submit" name="formSubmit" value=" Absenden ">
            <input type="reset" value=" Abbrechen">
          </td>
          </tr>
          </table>
</form>
<hr>
<h3>Debugging:</h3>

<?
global $values;
global $text1;
global $status;
foreach(array_keys($values) as $orbis) {
  echo "$description[$orbis]$values[$orbis]";
  echo ("<br>");
}

//print_r($_POST);
if(isset($_POST['formSubmit'])) {
  echo "<hr>";
  echo $text1;
}
echo "<hr>";
foreach(array_keys($status) as $key) {
  echo "$key: $status[$key]";
  echo ("<br>");
}
$tmp = ($values['2.7.0('] - $values['1.7.0(']);
?>

<script type="text/javascript" class="code">
  $(document).ready(function(){
    s1 = [<? global $tmp; echo $tmp?>]
    plot4 = $.jqplot('chart4',[s1],{
       seriesDefaults: {
           renderer: $.jqplot.MeterGaugeRenderer,
           rendererOptions: {
               label: 'Leistung',
               labelPosition: 'bottom',
               labelHeightAdjust: -5,
               intervalOuterRadius: 85,
               ticks: [-8000, -4000, 0, 4000, 8000],
               intervals:[-1000, 1000, 8000],
               intervalColors:['#ff0000', '#E7E658', '#00ff00']
           }
       }
   });
});
</script>

<hr>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <label for='formControl'>Wähle den Befehl aus</label><br>
        <select name="formControl">
                <option value="">...</option>
                <option value="GC">Strom (Min/Max)</option>
                <option value="GE">Aktueller Strom</option>
                <option value="SC">Setze Strom</option>
                <option value="GS">Aktueller Status</option>
                <option value="FE">Start Ladung</option>
                <option value="FS">Stopp Ladung</option>
                <option value="ST starthr startmin endhr endmin">Setze Timer</option>
                <option value="ST 0 0 0 0">Reset Timer</option>
                <option value="GT">Aktuelle Zeit</option>
                <option value="S1">Setze Zeit</option>
                <option value="FR">Reset EVSE</option>
        </select>
        <input type="checkbox" name="auto" <? global $status; if($status['Automatik'] == "Ja") echo "checked"?>>Automatikbetrieb<b>
          <table border="0" cellpadding="5" cellspacing="0" bgcolor="#E0E0E0">
          <tr>
            <td align="right">Vorgabestrom</td>
            <td><input name="curr" type="number" size="2" max="16" min="6" value="<? global $status; echo $status['GE']?>"></td>
          </tr>
          <tr>
            <td align="right">Start Stunde:Minute</td>
            <td><input name="starthr" type="number" size="2" max="23" min="0" value="8"></td>
            <td><input name="startmin" type="number" size="2" max="59" min="0" value="30"></td>
          </tr>
          <tr>
            <td align="right">Stop Stunde:Minute</td>
            <td><input name="endhr" type="number" size="2" max="23" min="0" value="16"></td>
            <td><input name="endmin" type="number" size="2" max="59" min="0" value="30"></td>
          </tr>
          <tr>
            <td align="right" valign="top">Kommentar:</td>
            <th colspan="4" align="left"><textarea name="Text" rows="2" cols="50"></textarea></th>
          </tr>
          <tr>
            <td align="right">Formular:</td>
            <td>
            <input type="submit" name="formSubmit" value=" Absenden ">
            <input type="reset" value=" Abbrechen">
          </td>
          </tr>
          </table>
</form>


</body>
</html>

