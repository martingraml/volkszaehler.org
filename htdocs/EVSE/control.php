#!php
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
<form action="/EVSE/control.php" method="post">
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
        <input type="checkbox" name="auto" value="true">Automatikbetrieb<br>
          <table border="0" cellpadding="5" cellspacing="0" bgcolor="#E0E0E0">
          <tr>
            <td align="right">Vorgabestrom</td>
            <td><input name="curr" type="number" size="2" max="16" min="6" value="6"></td>
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
<hr>
<h3>Debugging:</h3>
Leistung Bezug: 0.295<br>Leistung Einspeisung: 0.025<br>Zählerstand Bezug: 11341.819<br>Strom P1: 0.29<br>Strom P2: 1.00<br>Strom P3: 1.79<br>Phase P1: -104.2<br>Phase P2: -94.2<br>Phase P3: 43.4<br>Zählerstand Einspeisung: 7928.175<br><hr>GT: 7.1.2015 21:1:52<br>GS: 3<br>Vorgabestrom: 0<br>ST: 254<br>Zeitstempel: 20.01.2015 15:11:10<br>GE: 16<br>Automatik: Nein<br>SC: <br>Antwort: $OK 16 0000
<br>Befehl: <br>max P: 1.4<br><script type="text/javascript" class="code">$(document).ready(function(){s1 = [-270];   plot4 = $.jqplot('chart4',[s1],{
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
<form action="/EVSE/control.php" method="post">
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
        <input type="checkbox" name="auto" >Automatikbetrieb<b>
          <table border="0" cellpadding="5" cellspacing="0" bgcolor="#E0E0E0">
          <tr>
            <td align="right">Vorgabestrom</td>
            <td><input name="curr" type="number" size="2" max="16" min="6" value="16"></td>
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

