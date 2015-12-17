<?php

$url = "https://static.cibap.nl/ee/beheer/modules/roosters/create_rooster.php?element={$_GET['klas']}&soort={$_GET['soort']}&week={$_GET['week']}&jaar={$_GET['jaar']}";
$ch = curl_init();
     
if($ch === false)
{
    die('Failed to create curl object');
}
     
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
 
//proxy details
curl_setopt($ch, CURLOPT_PROXY, 'localhost:9050');
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
 
$data = curl_exec($ch);
curl_close($ch);
 
$html = $data;

/// start with nothing
$table = $start = $end = false;
/// 'Vrijdag' should be unique enough, but will fail if it appears elsewhere
$pos = strpos($html, 'Vr');


/// find your start and end based on reliable tags
if ( $pos !== false ) {
  $start = stripos($html, '<tr>', $pos);
  if ( $start !== false ) {
    $end = stripos($html, '</table>', $start);
  }
}

/// make sure we have a start and end
if ( $start !== false && $end !== false ) {
  /// we can now grab our table $html;
  $table = substr($html, $start, $end - $start);
  /// convert brs to something that wont be removed by strip_tags
  $table = preg_replace('#<br ?/>#i', "\n", $table);
}

if ( $table ) {
  /// break apart based on rows
  $rows = preg_split('#</tr>#i', $table);
  ///
  foreach ( $rows as $key => $row ) {
    $rows[$key] = preg_split('#</td>#i', $row);
  }
}
else {
  /// create so we avoid errors
  $rows = array();
}

/// change this here from a foreach to a for because it seems
/// foreach was working from a copy of $rows and so any modifications
/// we made to $rows while the loop was happening were ignored.
$lof = count($rows);
for ( $rkey=0; $rkey<$lof; $rkey++ ) {
  /// pull out the row
  $row = $rows[$rkey];
  /// step each cell in the row
  foreach ( $row as $ckey => $cell ) {
    /// pull out our rowspan value
    if ( preg_match('/ rowspan=.([0-9]+)./', $cell, $regs) ) {
      /// if rowspan is greater than one (i.e. spread across multirows)
      $rowspan = (int) $regs[1];
      if ( $rowspan > 1 ) {
        /// then copy this cell into the next row down, but decrease it's rowspan
        /// so that when we find it in the next row we know how many more times
        /// it should span down.
        $newcell = preg_replace('/( rowspan=.)([0-9]+)(.)/', '${1}'.($rowspan-1).'${3}', $cell);
        array_splice( $rows[$rkey+1], $ckey, 0, $newcell );
      }
    }
  }
}

/// now finally step the normalised table and get rid of the unwanted tags that remain
/// at the same time split our values in to something more useful
foreach ( $rows as $rkey => $row ) {
  foreach ( $row as $ckey => $cell ) {
    $rows[$rkey][$ckey] = preg_split('/\n+/',trim(strip_tags( $cell )));
  }
}

//Plaats uren in dagen
$dagen = array();
foreach($rows as $uurKey => $uur) {
	foreach($uur as $dagKey => $dag) {
		$dagen[$dagKey][$uurKey] = $dag;
	}
}

unset($dagen[0]);
unset($dagen[6]);


?>