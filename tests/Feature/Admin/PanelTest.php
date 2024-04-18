<?php

it('can render the dashboard page', function () {
    $response = $this->get('/admin');

    $response->assertStatus(200);
});
