<?php
/**
 * Created by PhpStorm.
 * User: Todos
 * Date: 8/02/2017
 * Time: 11:44 AM
 */
$var = '20/04/2012';
$date= implode("-", array_reverse(explode("/", $var)));

echo $date;