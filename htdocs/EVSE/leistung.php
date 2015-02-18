<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/l$ <html> <head>
<title>Leistung</title>
<!-- define some style elements-->
<style>
label,a
{
        font-family : Arial, Helvetica, sans-serif;
        font-size : 14px;
}

</style>

</head>

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
    font-size: 14pt;
}
</style>

<div id="chart4" class="plot" style="width:500px;height:300px;"></div>

<script type="text/javascript" src="../jsplot/plugins/jqplot.meterGaugeRenderer.js"></script>

<?php
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
$values = readValuesFromFile();
$tmp = ($values['2.7.0('] - $values['1.7.0('])*1000;
//echo $tmp;
//echo " W</h3>";
  echo "<script type=\"text/javascript\" class=\"code\">";
  echo "\$(document).ready(function(){";
  echo "s1 = [";
  $tmp = ($values['2.7.0('] - $values['1.7.0(']);
  echo $tmp;
  echo "];";
?>
   plot4 = $.jqplot('chart4',[s1],{
       seriesDefaults: {
           renderer: $.jqplot.MeterGaugeRenderer,
           rendererOptions: {
               label: 'Leistung<?global $tmp; echo " $tmp W";?>',
               labelPosition: 'bottom',
               labelHeightAdjust: -5,
               intervalOuterRadius: 85,
               ticks: [-6000, -3000, 0, 3000, 6000],
               intervals:[-1000, 1000, 6000],
               intervalColors:['#ff0000', '#E7E658', '#00ff00']
           }
       }
   });
});
</script>


</body>
</html>

