<?php

/**
 * Denah Area Parkir Samping — selaras layout fisik hotel.
 *
 * Jalan Umum: 2 label vertikal (blok atas S.8–S.14 & blok bawah S.7–S.1)
 * Jalan Keluar: baris 8 di antara kedua blok (tidak menutupi Jalan Umum)
 */
return [
    'grid_columns' => 4,
    'grid_rows' => 16,

    'road_public_north' => [
        'coordinate_x' => 2,
        'coordinate_y' => 1,
        'span_columns' => 1,
        'span_rows' => 7,
    ],

    'road_public_south' => [
        'coordinate_x' => 2,
        'coordinate_y' => 9,
        'span_columns' => 1,
        'span_rows' => 7,
    ],

    'exit_road' => [
        'coordinate_x' => 1,
        'coordinate_y' => 8,
        'span_columns' => 2,
    ],

    'road_pantura' => [
        'coordinate_x' => 1,
        'coordinate_y' => 16,
        'span_columns' => 2,
    ],

    'east_area' => [
        'coordinate_x' => 3,
        'coordinate_y' => 4,
        'span_columns' => 2,
        'span_rows' => 9,
    ],

    'slots' => [
        'S.14' => ['coordinate_x' => 1, 'coordinate_y' => 1],
        'S.13' => ['coordinate_x' => 1, 'coordinate_y' => 2],
        'S.12' => ['coordinate_x' => 1, 'coordinate_y' => 3],
        'S.11' => ['coordinate_x' => 1, 'coordinate_y' => 4],
        'S.10' => ['coordinate_x' => 1, 'coordinate_y' => 5],
        'S.9' => ['coordinate_x' => 1, 'coordinate_y' => 6],
        'S.8' => ['coordinate_x' => 1, 'coordinate_y' => 7],

        'S.7' => ['coordinate_x' => 1, 'coordinate_y' => 9],
        'S.6' => ['coordinate_x' => 1, 'coordinate_y' => 10],
        'S.5' => ['coordinate_x' => 1, 'coordinate_y' => 11],
        'S.4' => ['coordinate_x' => 1, 'coordinate_y' => 12],
        'S.3' => ['coordinate_x' => 1, 'coordinate_y' => 13],
        'S.2' => ['coordinate_x' => 1, 'coordinate_y' => 14],
        'S.1' => ['coordinate_x' => 1, 'coordinate_y' => 15],
    ],
];
