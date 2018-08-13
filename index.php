<?php
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/models/Poll.php";
require __DIR__ . "/config/app.php";

function format_poll($poll, $with_delete_token = false)
{
	$array = [
		"id" => $poll->id,
		"title" => $poll->title,
		"creation_date" => $poll->creation_date,
		"options" => $poll->options,
	];

	if ($with_delete_token === true)
		$array['delete_token'] = $poll->delete_token;

	return $array;
}

Flight::route("POST /polls", function () {
	$request = Flight::request();
	if ($request->type === "application/json")
	{
		$request_json = $request->data;
		$poll = Poll::create_poll($request_json);
		if ($poll)
			Flight::json(format_poll($poll, true), 201);
		else
			Flight::halt(403, "<h1>403 Forbidden</h1><h3>Invalid data.</h3>");
	}
	else
		Flight::halt(403, "<h1>403 Forbidden</h1><h3>Invalid Content-Type.</h3>");
});

Flight::route("GET /polls/@id:[a-fA-F0-9]+", function ($id) {
	$poll = Poll::load_poll($id);
	if ($poll)
	{
		if (Flight::request()->type === "application/json")
			Flight::json(format_poll($poll));
		else
		{
			Flight::render("poll", ["poll" => $poll], "body_content");
			Flight::render("layout");
		}
	}
	else
		Flight::notFound();
});

// POST /polls/:id/vote
// Take an array of options and add a vote for each given option.
Flight::route("POST /polls/@id:[a-fA-F0-9]+/vote", function ($id) {
	$poll = Poll::load_poll($id);
	if ($poll)
	{
		if (Flight::request()->type === "application/json")
		{
			if (isset(Flight::request()->data["options"]) && is_array(Flight::request()->data["options"]))
			{ // Check that an options id array exists.
				//TODO Check that only the authorized number of options are selected.
				$poll->vote(Flight::request()->data["options"]); // Vote for the given options.
				// Then save and show poll data.
				$poll->save();
				Flight::json(format_poll($poll));
			}
			else
				Flight::halt(403, "<h1>403 Forbidden</h1><h3>Invalid data.</h3>");
		}
		else
		{
			if (isset(Flight::request()->data["options"]))
			{ // Check that any data has been sent.
				$selected_options = Flight::request()->data["options"];
				if (is_string($selected_options))
				{ // If it is a string, input[type="radio"] were used so only one option is selected.
					$poll->vote([intval($selected_options)]); // Vote for the selected option.
					$poll->save();
					Flight::redirect("/polls/$id/results"); // Redirect to the results.
				} //TODO: Multiple options case.
				else
					Flight::redirect("/polls/$id"); // Error: Redirect to the vote page.
			}
			else
				Flight::redirect("/polls/$id"); // Error: Redirect to the vote page.
			//TODO Error code in query parameters?
		}
	}
	else
		Flight::notFound();
});

Flight::route("GET /polls/@id:[a-fA-F0-9]+/results", function ($id) {
	$poll = Poll::load_poll($id);
	if ($poll)
	{
		if (Flight::request()->type === "application/json")
			Flight::json(format_poll($poll)); //TODO Add a svg for results?
		else
		{
			Flight::render("svg/results", ["poll" => $poll], "results_chart");
			Flight::render("results", ["poll" => $poll], "body_content");
			Flight::render("layout");
		}
	}
	else
		Flight::notFound();
});

Flight::route("GET|DELETE /polls/@id:[a-fA-F0-9]+/@token:[a-fA-F0-9]+", function ($id, $token) {
	$poll = Poll::load_poll($id);
	if ($poll)
	{
		if (Flight::request()->type === "application/json")
		{
			if ($poll->delete_token === $token)
			{
				$poll->delete();
				Flight::json(format_poll($poll), 204);
			}
			else
				Flight::halt(401, "<h1>401 Unauthorized</h1><h3>Invalid token.</h3>");
		}
		else
		{
			if ($poll->delete_token === $token)
			{
				$poll->delete();
				Flight::redirect('/', 204);
			}
			else
				Flight::redirect('/', 401);
		}
	}
	else
		Flight::notFound();
});

Flight::route("/", function () {
	global $VERLAINE;
	Flight::render("home", ["app_url" => $VERLAINE["app_url"]], "body_content");
	Flight::render("layout");
});

Flight::start();