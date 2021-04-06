<?php

return [
    /**
     * ---------------------------------------------------------------------
     * Passport configuration
     * ---------------------------------------------------------------------
     * The following configuration for passport are supposed to be use only
     * on the development or the test environment.
     *
     */
    'passport' => [
        'client_id' => env('PASSPORT_ACCESS_CLIENT_ID', 1),
        'client_secret' => env('PASSPORT_ACCESS_CLIENT_SECRET', 'dolphin_dancing_in_the_sky')
    ]
];
