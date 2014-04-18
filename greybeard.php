<?php

require_once('inc/loader.php');
// $config now exists

$data = array();
$data[CONFIG] = Spyc::YAMLLoad($config->get('FILE__CFG__GLOBAL'));
$data[WANTED] = Spyc::YAMLLoad($config->get('FILE__CFG__WANTED'));
$data[OFFERS] = Spyc::YAMLLoad($config->get('FILE__CFG__OFFERS'));

print_r($data);


