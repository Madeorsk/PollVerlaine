<?php
define("CIRCLE_R", 50);

$colors_number = count($colors);

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
	foreach ($poll->options as $index => $option):
		if($options_percentages[$index] == 1): ?>
	<circle cx="0" cy="0" r="<?= CIRCLE_R ?>" fill="<?= $colors[$index%$colors_number] ?>"></circle>
	<?php elseif($options_percentages[$index] != 0): ?>
	<path d="M<?= percentage_pos_x(CIRCLE_R, $used_percentage) ?> <?= percentage_pos_y(CIRCLE_R, $used_percentage) ?> A<?= CIRCLE_R." ".CIRCLE_R ?> 0 <?= ($options_percentages[$index] > 0.5 ? 1 : 0) ?> 1 <?= percentage_pos_x(CIRCLE_R, $used_percentage + $options_percentages[$index]) ?> <?= percentage_pos_y(CIRCLE_R, $used_percentage + $options_percentages[$index]) ?> L0 0" fill="<?= $colors[$index%$colors_number] ?>"></path>
	<?php endif; ?>
	<?php $used_percentage += $options_percentages[$index]; endforeach; ?>
</svg>