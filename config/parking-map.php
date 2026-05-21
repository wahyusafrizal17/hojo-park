<?php

/**
 * Denah Area Parkir Belakang — selaras sketsa fisik hotel.
 *
 * Baris 1: B.11 → B.1 + Area Motor (sejajar kolom B.27–B.30)
 * Baris 3: B.12 → B.20
 * Baris 4: Pintu Masuk (di atas B.27–B.30, sejajar Area Motor)
 * Baris 5: B.21, B.22 | celah | B.23 → B.30
 * Kolom 16: Jalan Umum
 */
return [
    'grid_columns' => 16,
    'grid_rows' => 5,

    /** Area motor — kolom B.27–B.30, tinggi sampai baris B.20 */
    'motor_area' => [
        'coordinate_x' => 12,
        'coordinate_y' => 1,
        'span_columns' => 4,
        'span_rows' => 3,
    ],

    'road_east' => [
        'coordinate_x' => 16,
        'coordinate_y' => 1,
        'span_columns' => 1,
        'span_rows' => 5,
    ],

    /** Pintu masuk — lorong di atas B.27–B.30 (lebar = Area Motor) */
    'entrance' => [
        'coordinate_x' => 12,
        'coordinate_y' => 4,
        'span_columns' => 4,
        'span_rows' => 1,
    ],

    'slots' => [
        'B.11' => ['coordinate_x' => 1, 'coordinate_y' => 1],
        'B.10' => ['coordinate_x' => 2, 'coordinate_y' => 1],
        'B.9' => ['coordinate_x' => 3, 'coordinate_y' => 1],
        'B.8' => ['coordinate_x' => 4, 'coordinate_y' => 1],
        'B.7' => ['coordinate_x' => 5, 'coordinate_y' => 1],
        'B.6' => ['coordinate_x' => 6, 'coordinate_y' => 1],
        'B.5' => ['coordinate_x' => 7, 'coordinate_y' => 1],
        'B.4' => ['coordinate_x' => 8, 'coordinate_y' => 1],
        'B.3' => ['coordinate_x' => 9, 'coordinate_y' => 1],
        'B.2' => ['coordinate_x' => 10, 'coordinate_y' => 1],
        'B.1' => ['coordinate_x' => 11, 'coordinate_y' => 1],

        'B.12' => ['coordinate_x' => 2, 'coordinate_y' => 3],
        'B.13' => ['coordinate_x' => 3, 'coordinate_y' => 3],
        'B.14' => ['coordinate_x' => 4, 'coordinate_y' => 3],
        'B.15' => ['coordinate_x' => 5, 'coordinate_y' => 3],
        'B.16' => ['coordinate_x' => 6, 'coordinate_y' => 3],
        'B.17' => ['coordinate_x' => 7, 'coordinate_y' => 3],
        'B.18' => ['coordinate_x' => 8, 'coordinate_y' => 3],
        'B.19' => ['coordinate_x' => 9, 'coordinate_y' => 3],
        'B.20' => ['coordinate_x' => 10, 'coordinate_y' => 3],

        'B.21' => ['coordinate_x' => 1, 'coordinate_y' => 5],
        'B.22' => ['coordinate_x' => 2, 'coordinate_y' => 5],
        'B.23' => ['coordinate_x' => 8, 'coordinate_y' => 5],
        'B.24' => ['coordinate_x' => 9, 'coordinate_y' => 5],
        'B.25' => ['coordinate_x' => 10, 'coordinate_y' => 5],
        'B.26' => ['coordinate_x' => 11, 'coordinate_y' => 5],
        'B.27' => ['coordinate_x' => 12, 'coordinate_y' => 5],
        'B.28' => ['coordinate_x' => 13, 'coordinate_y' => 5],
        'B.29' => ['coordinate_x' => 14, 'coordinate_y' => 5],
        'B.30' => ['coordinate_x' => 15, 'coordinate_y' => 5],
    ],
];
