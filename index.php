<?php
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/models/Poll.php";
require __DIR__ . "/config/app.php";

function format_poll($poll)
{
	return [
		"id" => $poll->id,
		"title" => $poll->title,
		"creation_date" => $poll->creation_date,
		"options" => $poll->options,
	];
}

Flight::route("POST /polls", function () {
	$request = Flight::request();
	if ($request->type === "application/json")
	{
		$request_json = $request->data;
		$poll = Poll::create_poll($request_json);
		if ($poll)
			Flight::json(format_poll($poll), 206);
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

Flight::route("/", function () {
	global $VERLAINE;
	Flight::render("home", ["app_url" => $VERLAINE["app_url"]], "body_content");
	Flight::render("layout");
});

Flight::start();