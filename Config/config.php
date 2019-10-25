<?php

return [
    'name' => 'RightsManagement',
    'routePrefix' => 'admins', // no trailing slash required
    'authGuard' => 'admin',
    'defaultLayout' => 'admin.layouts' // no trailing fullstop required
];
