<?php

namespace GameZone;

class DateHelper {

	/**
	 * @param int $timestamp
	 * @return string
	 */
	public static function germanDateFromTimestamp(int $timestamp):string {
		return date('d.m.Y', $timestamp);
	}

	/**
	 * @param int $timestamp
	 * @return string
	 */
	public static function englishDateFromTimestamp(int $timestamp):string {
		return date('Y-m-d', $timestamp);
	}

	/**
	 * @param string $date
	 * @return int
	 */
	public static function timestampFromDate(string $date):int {
		return strtotime($date);
	}

}