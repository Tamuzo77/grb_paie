<?php

test('its get function return correct value for [0-60000]', function () {
    $salaire = rand(0, 60000);
    $its = \App\Services\ItsService::getIts(salaire: $salaire);

    expect($its)->toBe(0);
});
test('its get function return correct value for [60001 - 150000]', function () {
    $salaire = rand(60001, 150000);
    $its = \App\Services\ItsService::getIts(salaire: $salaire);

    expect($its)->toBe(10);
});
test('its get function return correct value for [150001 - 250000]', function () {
    $salaire = rand(150001, 250000);
    $its = \App\Services\ItsService::getIts(salaire: $salaire);

    expect($its)->toBe(15);
});
test('its get function return correct value for [250001 - 500000]', function () {
    $salaire = rand(250001, 500000);
    $its = \App\Services\ItsService::getIts(salaire: $salaire);

    expect($its)->toBe(19);
});
test('its get function return correct value for [500001+]', function () {
    $salaire = rand(500001, 99999999);
    $its = \App\Services\ItsService::getIts(salaire: $salaire);

    expect($its)->toBe(30);
});
