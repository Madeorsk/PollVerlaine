<?php
$total_votes = 0;
foreach ($poll->options as $option)
  $total_votes += $option->votes;
?>
<h1 class="poll"><?= $poll->title ?></h1>
<main class="results">
  <div class="options">
    <table>
      <?php foreach ($poll->options as $option): ?>
      <tr>
        <td class="number"><?= $option->votes ?></td>
        <td><?= $option->label ?></td>
        <td><?= round($option->votes / $total_votes, 3)*100 ?>%</td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <div class="chart">
	  <?= $results_chart ?>
  </div>
</main>