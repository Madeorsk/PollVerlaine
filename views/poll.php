<h1 class="poll"><?= $poll->title ?></h1>
<main>
  <form action="#" id="poll">
    <?php foreach ($poll->options as $option): ?>
    <div class="option">
      <input type="radio" name="options" value="<?= $option->id ?>" id="option-<?= $option->id ?>" />
      <label for="option-<?= $option->id ?>" class="check"></label>
      <label for="option-<?= $option->id ?>"><?= $option->label ?></label>
    </div>
    <?php endforeach; ?>
    <input type="submit" value="Vote" />
  </form>
  <a class="button margin">Jump to results</a>
</main>