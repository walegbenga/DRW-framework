function toggleText($text1, $link1, $text2, $link2) 
{ 
   $tok = rand(0, 1000000); 
   $out   = "<div id='PIPHP_TT1_$tok' style='display:block;'>" . 
            "<a href=\"javascript://\" onClick=\"document." . 
            "getElementById('PIPHP_TT1_$tok').style.display=" . 
            "'none'; document.getElementById('PIPHP_TT2_$tok')" . 
            ".style.display='block';\">$link1</a>$text1</div>\n"; 
 
   $out  .= "<div id='PIPHP_TT2_$tok' style='display:none;'>" . 
            "<a href=\"javascript://\" onClick=\"document." . 
            "getElementById('PIPHP_TT1_$tok').style.display=" . 
            "'block'; document.getElementById('PIPHP_TT2_$tok')" . 
            ".style.display='none';\">$link2</a>$text2</div>\n"; 
   return  $out; 
}