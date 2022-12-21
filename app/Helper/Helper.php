<?php

namespace App\Helper;

class Helper
{

	public static function numOnly($input) {
		return preg_replace('/[^0-9]/','', $input);
	}

	public static function generate_id_number($input, $pad_len = 5, $prefix = null) {
		if(strlen($input) > $pad_len)
			$pad_len = strlen($input);

		if (is_string($prefix))
			return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

		return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
	}

    public static function clean($string) {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9_\-]/', '', strtolower($string)); // Removes special chars.
    }

    public static function validEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @throws \Exception
     */
    public static function addBusinessDays(\DateTime $startDateTime, $daysToAdd)
    {
        $endDateTime = clone $startDateTime;
        $endDateTime->add(new \DateInterval('P' . $daysToAdd . 'D'));
        $period = new \DatePeriod(
            $startDateTime, new \DateInterval('P1D'), $endDateTime,
            // Exclude the start day
            \DatePeriod::EXCLUDE_START_DATE
        );

        $periodIterator = new PeriodIterator($period);
        $adjustedEndingDate = clone $startDateTime;
        while($periodIterator->valid()){
            $adjustedEndingDate = $periodIterator->current();
            // If we run into a weekend, extend our days
            if($periodIterator->isWeekend()){
                $periodIterator->extend();
            }
            $periodIterator->next();
        }

        return $adjustedEndingDate;
    }
}
