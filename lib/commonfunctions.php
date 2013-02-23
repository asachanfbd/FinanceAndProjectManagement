<?php
function plural($num) {
    if ($num != 1)
        return "s";
}

function calcreltime($date) {
    $diff = time() - ($date);
    if ($diff<60)
        return $diff . " second" . plural($diff) . " ago";
    $diff = round($diff/60);
    if ($diff<60)
        return $diff . " minute" . plural($diff) . " ago";
    $diff = round($diff/60);
    if ($diff<24)
        return $diff . " hour" . plural($diff) . " ago";
    $diff = round($diff/24);
    if ($diff<7)
        return $diff . " day" . plural($diff) . " ago";
    $diff = round($diff/7);
    if ($diff<4)
        return $diff . " week" . plural($diff) . " ago";
    return  "on " . date("F j, Y", ($date));
}

function getRelativeTime($ts){
    return "<span class='timeautoupdate' timestamp='".$ts."' title='".date("l, M d, Y", $ts)." at ".date("h:i A", $ts)."'>".calcreltime($ts)."</span>";
}
?>
