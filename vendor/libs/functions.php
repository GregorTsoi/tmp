<?php
function debug($arr,$title = 'Заголовок') {

    echo '<h2>'.$title.'</h2>';
    echo '<div style="background-color: lightgrey">';
    echo '<hr><pre>' . print_r($arr,true).'</pre><hr>';
    echo '</div>';
    }