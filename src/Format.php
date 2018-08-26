<?php

class Format
{
	public static function poll($poll)
	{
		return [
			"id" => $poll->id,
			"title" => $poll->title,
			"creation_date" => $poll->creation_date,
			"options" => $poll->options,
		];
	}
}