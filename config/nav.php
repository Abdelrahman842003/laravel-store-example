<?php

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'Dashboard.Dashboard',
        'title' => 'Dashboard',
        'active' => 'Dashboard.Dashboard',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'Dashboard.categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'Dashboard.categories.*',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'Dashboard.products.index',
        'title' => 'Products',
        'active' => 'Dashboard.products.*',
    ],
    [
        'icon' => 'far fa-circle nav-icon',
        'route' => 'Dashboard.categories.index',
        'title' => 'Orders',
        'active' => 'Dashboard.orders.*',
    ]
];
