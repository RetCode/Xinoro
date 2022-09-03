<?php

    class Date
    {
        static function DateTimeToRealTime($DateTime,$isShortString = false)
        {
            $date = strtotime($DateTime);
            $currentDate = strtotime(date("Y-m-d H:i:s"));

            if($date+300 < $currentDate)
            {
                if($date+86400 > $currentDate)
                    return $isShortString ? "Cегодня в ".date("H:i",$date) : "Был сегодня в ".date("H:i",$date);
                
                if($date+172800 > $currentDate)
                    return $isShortString ? "Вчера в ".date("H:i",$date) : "Был вчера в ".date("H:i",$date);

                if($date+259200 < $currentDate)
                    return $isShortString ? "Был(а) ".date("H:i",$date) : "Был ".date("d M Y",$date);
            }
            else
            {
                return "Онлайн";
            }
        }

        static function MDateTimeToRealTime($DateTime)
        {
            $date = strtotime($DateTime);
            $currentDate = strtotime(date("Y-m-d H:i:s"));

            if($date+86400 > $currentDate)
                return "Сегодня";
            
            if($date+172800 > $currentDate)
                return "Вчера";

            if($date+259200 < $currentDate)
                return date("d M Y",$date);
        }

        static function MFDateTimeToRealTime($DateTime)
        {
            $date = strtotime($DateTime);
            $currentDate = strtotime(date("Y-m-d H:i:s"));

            if($date+86400 > $currentDate)
                return "Сегодня в ".date("H:i",$date);
            
            if($date+172800 > $currentDate)
                return "Вчера в ".date("H:i",$date);

            if($date+259200 < $currentDate)
                return date("d.m.Y",$date);
        }
    }

?>