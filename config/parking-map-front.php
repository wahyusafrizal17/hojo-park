<?php

/**
 * Denah Area Parkir Depan — 2 kolom rapat.
 *
 * VIP 2: kolom paling barat (di luar / kiri pintu masuk)
 * Pintu Masuk: kolom kedua dari kiri
 */
return [
    'grid_columns' => 6,
    'grid_rows' => 8,

    'entrance_west' => [
        'coordinate_x' => 2,
        'coordinate_y' => 3,
        'span_columns' => 1,
        'span_rows' => 5,
    ],

    'exit_east' => [
        'coordinate_x' => 5,
        'coordinate_y' => 3,
        'span_columns' => 1,
        'span_rows' => 5,
    ],

    'exit_northeast' => [
        'coordinate_x' => 5,
        'coordinate_y' => 1,
        'span_columns' => 2,
        'span_rows' => 1,
    ],

    'road_pantura' => [
        'coordinate_x' => 2,
        'coordinate_y' => 8,
        'span_columns' => 4,
    ],

    'slots' => [
        // VIP 2 — paling kiri, tidak sejajar kolom pintu masuk
        'VIP 2' => ['coordinate_x' => 1, 'coordinate_y' => 1],

        'VIP 1' => ['coordinate_x' => 3, 'coordinate_y' => 2, 'span_columns' => 2, 'span_rows' => 1],

        'D.5' => ['coordinate_x' => 3, 'coordinate_y' => 3],
        'D.6' => ['coordinate_x' => 4, 'coordinate_y' => 3],

        'D.4' => ['coordinate_x' => 3, 'coordinate_y' => 4],
        'D.3' => ['coordinate_x' => 3, 'coordinate_y' => 5],
        'D.2' => ['coordinate_x' => 3, 'coordinate_y' => 6],
        'D.1' => ['coordinate_x' => 3, 'coordinate_y' => 7],

        'D.7' => ['coordinate_x' => 4, 'coordinate_y' => 4],
        'D.8' => ['coordinate_x' => 4, 'coordinate_y' => 5],
        'D.9' => ['coordinate_x' => 4, 'coordinate_y' => 6],
        'D.10' => ['coordinate_x' => 4, 'coordinate_y' => 7],
    ],
];
