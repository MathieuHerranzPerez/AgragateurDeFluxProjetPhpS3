<?php
if (isset($data['exception'])) {
    echo '<p class="error">Une erreur est survenue : '.$data['exception']->getMessage().'</p>';
}
?>