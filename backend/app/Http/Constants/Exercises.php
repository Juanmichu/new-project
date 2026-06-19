<?php

namespace App\Http\Constants;

final class Exercises
{
    const DIFFICULTY_LEVELS       = [
        'Beginner',
        'Intermediate',
        'Advanced'
    ];
    const COLOR_DIFFICULTY_LEVELS = [
        'Beginner' => 'green',
        'Intermediate' => 'purple',
        'Advanced' => 'red'
    ];

    const MUSCLE_GROUPS = [
        'Chest',
        'Back',
        'Legs',
        'Arms',
        'Biceps',
        'Triceps',
        'Core',
        'Shoulders',
        'Full Body',
        'Cardio',
        'Glutes',
        'Calves',
        'Forearms',
        'Neck'
    ];

    const EQUIPMENT_TYPES = [
        'Dumbbell',
        'Pull Up Bar',
        'Machine',
        'Elastic Band',
        'Bodyweight',
        'Kettlebell',
        'Discs',
        'Bar',
        'Step',
        'Cable'
    ];

    const DEFAULT_EQUIPMENT_TYPE = 'Bodyweight';
}
