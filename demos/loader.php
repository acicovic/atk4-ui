<?php

require 'init.php';

/**** Start on page load ***/
$app->add(['Header', 'Attach loader to default view and start it on page load.']);
$l1 = $app->add('Loader');
$l1->needOnPageLoad = true;

$l1->set(function ($loader) {
    //set your time expensive function here.
    sleep(2);
    $loader->add(new \atk4\ui\LoremIpsum(['size'=>1]));
});

$app->add(['Header', 'Attach loader in supplied view and start it using an action.']);

/*** Start from a user action ***/
$l2 = $app->add(new \atk4\ui\Loader(['loader'=> new atk4\ui\View(['ui'=> 'segment'])]));
$l2->set(function ($loader) {
    //set your time expensive function here.
    sleep(2);
    $loader->add(new \atk4\ui\Message(['text' => 'Load using button']));
});

//Start via user action.
$b = $app->add(['Button', 'Start Loader']);
$b->on('click', $l2->jsStartLoader());

/*** Start from a user action in a button ***/
$app->add(['Header', 'Attach loader to supplied button and start it via same button.']);

$btn_load = new atk4\ui\Button();
$btn_load->set(['Load', 'primary']);

$l3 = $app->add(new \atk4\ui\Loader(['loader'=> $btn_load]));
$l3->set(function ($loader) {
    //set your time expensive function here.
    sleep(2);
    $loader->set(['Loaded']);
    $loader->addClass('disabled');
});

//Start via user action.
$btn_load->on('click', $l3->jsStartLoader());
