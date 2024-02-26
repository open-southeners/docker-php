<?php

use OpenSoutheners\Docker\Client;

beforeEach(function () {
    $this->client = new Client('http://localhost:2375');
});

test('create container returns array result with no warnings', function () {
    $container = $this->client->createContainer([
        'Image' => 'alpine:3.18',
    ], 'docker_php_test');

    expect($container)->toBeArray();

    expect($container['Warnings'])->toBeArray();
    expect($container['Warnings'])->toBeEmpty();
    expect($container['Id'])->toBeString();

    $this->containerId = $container['Id'];
});

test('list running containers returns array', function () {
    $containers = $this->client->getContainers();

    expect($containers)->toBeArray();

    $firstContainer = reset($containers);

    expect($firstContainer)->toBeArray();
    expect($firstContainer)->toHaveKeys([
        'Id', 'Names', 'Image', 'ImageID', 'Command',
        'Created', 'Ports', 'Labels', 'State', 'Status',
        'HostConfig', 'NetworkSettings', 'Mounts',
    ]);
});

test('get container by ID returns array', function () {
    $container = $this->client->getContainer('docker_php_initial_container');

    expect($container)->toBeArray();
    expect($container)->toHaveKeys([
        'Id', 'Created', 'Path', 'Args', 'State',
        'Image', 'ResolvConfPath', 'HostnamePath', 'HostsPath', 'LogPath',
        'Name', 'RestartCount', 'Driver', 'Platform', 'MountLabel',
        'ProcessLabel', 'AppArmorProfile', 'ExecIDs', 'HostConfig',
        'GraphDriver', 'Mounts', 'Config', 'NetworkSettings'
    ]);
});

test('stop container returns empty response', function () {
    $result = $this->client->stopContainer('docker_php_test');

    expect($result)->toBeNull();
})->depends('create container returns array result with no warnings');

test('remove container returns array result with no warnings', function () {
    $result = $this->client->removeContainer('docker_php_test');

    expect($result)->toBeNull();
})->depends('stop container returns empty response');
