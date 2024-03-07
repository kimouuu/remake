// app/Helpers.php
<?php

function censorLastFourDigits($phone)
{
    return substr($phone, 0, -4) . str_repeat('*', 4);
}
