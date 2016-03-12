<?php

require 'vendor/autoload.php';

use Stagehand\FSM\StateMachine\StateMachineBuilder;

$stateMachineBuilder = new StateMachineBuilder();
$stateMachineBuilder->addState('S');
$stateMachineBuilder->addState('ズン0');
$stateMachineBuilder->addState('ズン1');
$stateMachineBuilder->addState('ズン2');
$stateMachineBuilder->addState('ズン3');
$stateMachineBuilder->addState('ドコ0');
$stateMachineBuilder->addState('ドコ1');
$stateMachineBuilder->setStartState('S');
$stateMachineBuilder->addTransition('S', 0, 'ズン0');
$stateMachineBuilder->addTransition('S', 1, 'ドコ0');
$stateMachineBuilder->addTransition('ズン0', 0, 'ズン1');
$stateMachineBuilder->addTransition('ズン0', 1, 'ドコ0');
$stateMachineBuilder->addTransition('ズン1', 0, 'ズン2');
$stateMachineBuilder->addTransition('ズン1', 1, 'ドコ0');
$stateMachineBuilder->addTransition('ズン2', 0, 'ズン3');
$stateMachineBuilder->addTransition('ズン2', 1, 'ドコ0');
$stateMachineBuilder->addTransition('ズン3', 0, 'ズン3');
$stateMachineBuilder->addTransition('ズン3', 1, 'ドコ1');
$stateMachineBuilder->addTransition('ドコ0', 0, 'ズン0');
$stateMachineBuilder->addTransition('ドコ0', 1, 'ドコ0');
$stateMachine = $stateMachineBuilder->getStateMachine();

function normalize($stateId) {
    if (strncmp($stateId, 'S', 1) === 0) { return ''; }
    if (strncmp($stateId, 'ズン', 2) === 0) { return 'ズン'; }
    if (strncmp($stateId, 'ドコ', 2) === 0) { return 'ドコ'; }
    return '';
}

$stateMachine->start();
while ($stateMachine->getCurrentState()->getStateID() !== 'ドコ1') {
    echo normalize($stateMachine->getCurrentState()->getStateID());
    $randomness = rand(0,1);
    $stateMachine->triggerEvent($randomness);
}
echo "ドコキ・ヨ・シ!" . PHP_EOL;
