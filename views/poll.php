<h1 class="poll"><?= $poll->title ?></h1>
<main>
  <form action="<?= $app_url ?>/polls/<?= $poll->id ?>/vote" method="POST" id="poll">
    <?php foreach ($poll->options as $id => $option): ?>
    <div class="option">
      <input type="<?= $poll->settings->multiple_choices ? "checkbox" : "radio" ?>" name="options[]" value="<?= $id ?>" id="option-<?= $id ?>" />
      <label for="option-<?= $id ?>" class="check"></label>
      <label for="option-<?= $id ?>"><?= htmlspecialchars($option->label) ?></label>
    </div>
    <?php endforeach; ?>
    <input type="submit" value="Vote" />
  </form>
  <a class="button margin" href="<?= $app_url ?>/polls/<?= $poll->id ?>/results">Jump to results</a>
</main>