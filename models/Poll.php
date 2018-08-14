<?php

define("SAVE_PATH", __DIR__ . "/../db");

class Poll
{
	/**
	 * Create a new poll and save it.
	 */
	public static function create_poll($request_data)
	{
		try
		{
			$poll = new Poll();
			$poll->title = $request_data->title;
			$poll->creation_date = (new DateTime())->getTimestamp();
			foreach ($request_data->options as $option)
			{
				$poll->options[] = [
					"label" => $option,
					"votes" => 0,
				];
			}
			$poll->settings = $request_data->settings;
			$poll->gen_new_id();
			$poll->delete_token = bin2hex(openssl_random_pseudo_bytes(16));
			$poll->save();
			return $poll;
		}
		catch (Exception $e)
		{ return false; }
	}

	/**
	 * Try to load an existing poll.
	 * @param string id - Poll ID.
	 * @return boolean|Poll - Requested poll if found, false otherwise.
	 */
	public static function load_poll($id)
	{
		$db = dba_open(SAVE_PATH . "/polls.db", "rd");

		if (dba_exists($id, $db))
		{
			$poll = new Poll();
			$saved_poll_data = json_decode(dba_fetch($id, $db));
			$poll->id = $id;
			$poll->title = $saved_poll_data->title;
			$poll->creation_date = $saved_poll_data->creation_date;
			$poll->options = $saved_poll_data->options;
			$poll->delete_token = $saved_poll_data->delete_token;
			$poll->settings = $saved_poll_data->settings;
			$poll->ips = (array) $saved_poll_data->ips;

			dba_close($db);
			return $poll;
		}
		else
		{
			dba_close($db);
			return false;
		}
	}

	public $id = null;
	public $title;
	public $creation_date;
	public $options = [];
	public $settings = [];
	public $ips = [];
	public $delete_token;

	private function gen_new_id()
	{
		$db = dba_open(SAVE_PATH . "/polls.db", "rd");

		function gen_id()
		{ return bin2hex(openssl_random_pseudo_bytes(16)); }

		do
		{ $new_id = gen_id(); }
		while(dba_exists($new_id, $db));

		dba_close($db);
		$this->id = $new_id;
	}

	/**
	 * Vote for a list of options.
	 * @param array $options - Array of integers containing voted options.
	 * @return bool
	 */
	public function vote(array $options)
	{
		if($this->settings->unique_ip === false)
		{
			if(isset($this->ips[Flight::request()->ip]))
				return false;
			else
				$this->ips[Flight::request()->ip] = true;
		}

		// For each option in the list, add 1 to the vote number in the poll data.
		foreach ($options as $option)
			if (isset($this->options[intval($option)])) // Check invalid options id.
				$this->options[intval($option)]->votes++;
		return true;
	}

	public function save()
	{
		$db = dba_open(SAVE_PATH . "/polls.db", "wd");
		$func = (dba_exists($this->id, $db) ? "dba_replace" : "dba_insert");
		$func($this->id, json_encode([
			"title" => $this->title,
			"creation_date" => $this->creation_date,
			"options" => $this->options,
			"delete_token" => $this->delete_token,
			"ips" => $this->ips,
			"settings" => $this->settings
		]), $db);
		dba_close($db);
	}

	public function delete()
	{
		$db = dba_open(SAVE_PATH . "/polls.db", "wd");
		dba_delete($this->id, $db);
		dba_close($db);
	}
}
