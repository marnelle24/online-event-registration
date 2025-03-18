<?php
    namespace App\Helpers;
    
    class Helper
    {
        /**
         * Get the initials of a string, 
         * For example:
         * "John Doe" will return "JD"
         * "John" will return "J"
         * "John Doe Smith" will return "JD"
         * 
         * @param string $string
         * @return string
         */
        public static function getInitials(string $string)
        {
            $words = explode(' ', trim($string));
            $initials = '';
            
            foreach ($words as $word) 
            {
                if (!empty($word)) 
                    $initials .= strtoupper(substr($word, 0, 1));
            }
            
            $initials = substr($initials, 0, 2);
            return $initials;
        } 
    }