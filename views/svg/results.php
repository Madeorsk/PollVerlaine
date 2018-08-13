<?php

define("CIRCLE_R", 50);

$COLORS = [
	"#FF4B44", // Red.
	"#FFD149", // Yellow.
	"#56B3FF", // Dark blue.
	"#FF9535", // Orange.
	"#7DFF59", // Green.
	"#FFAFEC", // Pink.
	"#82FFE8", // Light blue.
];

$total_votes = 0;
foreach ($poll->options as $option)
	$total_votes += $option->votes;

$options_percentages = [];
foreach ($poll->options as $option)
	$options_percentages[] = $option->votes / $total_votes;

function percentage_pos_x($r, $percentage)
{ return round($r * sin(2 * M_PI * $percentage), 2); }
function percentage_pos_y($r, $percentage)
{ return -1*round($r * cos(2 * M_PI * $percentage), 2); }

//TODO Improve by showing values in the colors.

?>

<svg xmlns="http://www.w3.org/2000/svg" viewBox="-<?= CIRCLE_R ?> -<?= CIRCLE_R ?> <?= CIRCLE_R*2 ?> <?= CIRCLE_R*2 ?>">
	<circle cx="0" cy="0" r="<?= CIRCLE_R ?>" fill="black" fill-opacity="0.2"></circle>
	<?php
	$used_percentage = 0;
	foreach ($poll->options as $index => $option): ?>
	<path d="M<?= percentage_pos_x(CIRCLE_R, $used_percentage) ?> <?= percentage_pos_y(CIRCLE_R, $used_percentage) ?> A<?= CIRCLE_R." ".CIRCLE_R ?> 0 <?= ($options_percentages[$index] > 0.5 ? 1 : 0) ?> 1 <?= percentage_pos_x(CIRCLE_R, $used_percentage + $options_percentages[$index]) ?> <?= percentage_pos_y(CIRCLE_R, $used_percentage + $options_percentages[$index]) ?> L0 0" fill="<?= $COLORS[$index%7] ?>"></path>
	<?php $used_percentage += $options_percentages[$index]; endforeach; ?>
</svg>