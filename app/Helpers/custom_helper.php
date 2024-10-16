<?php

if (!function_exists('parsingAlert')) {
    function parsingAlert($message)
    {
        $string = '<ul>'; // Start the unordered list

        if (is_array($message)) {
            foreach ($message as $value) {
                $string .= '<li>' . ucfirst($value) . '</li>'; // Wrap each message in a <li>
            }
        } else {
            $string .= '<li>' . ucfirst($message) . '</li>'; // If it's not an array, wrap the single message in a <li>
        }

        $string .= '</ul>'; // Close the unordered list

        return $string;
    }
}
