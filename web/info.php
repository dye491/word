<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.06.18
 * Time: 11:02
 */

exec("env", $output);
echo '<pre>';
foreach ($output as $line)
    echo "$line\n";
echo '</pre>';
phpinfo();