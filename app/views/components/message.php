<?php
if(isset($errors) && count($errors) > 0) {
    foreach($errors as $error_msg) {
        echo '<div class="alert alert-danger" role="alert">'.$error_msg.'</div>';
    }
}
if(isset($success)) {
    echo '<div class="alert alert-success" role="alert">'.$success.'</div>';
}
