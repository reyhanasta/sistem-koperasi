<?php
namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Str;

class UsernameHelper
{/**
     * Generate a unique username based on the first name and registration date.
     *
     * @param string $name
     * @param string $registrationDate
     * @return string
     */
    public static function generateUsername(string $name, string $registrationDate): string
    {
        // Split the name into words and take the first word
        $words = explode(' ', $name);
        $firstName = strtolower($words[0]);

        // Extract day and month from the registration date
        $date = \DateTime::createFromFormat('Y-m-d', $registrationDate);
        $dayMonth = $date->format('dm');

        // Combine first name and day+month to create the base username
        $baseUsername = $firstName . $dayMonth;
        $username = $baseUsername;

        // Ensure the username is unique
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
