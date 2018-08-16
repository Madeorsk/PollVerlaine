<body class="home">
<script src="/static/js/fetch.min.js"></script>
<script src="/static/js/new.js"></script>

<h1>Poll Verlaine</h1>
<main>
  <form action="#" id="newpoll">
    <input type="text" name="title" placeholder="What do you want to ask?" required />
    <div id="choices">
    </div>
    <button type="button" id="add-choice">New choice</button>
    <hr/>
    <div class="option">
      <input type="checkbox" name="unique_ip" value="unique_ip" id="unique_ip" checked />
      <label for="unique_ip" class="check"></label>
      <label for="unique_ip">Allow multiple votes from a single IP</label>
    </div>
    <input type="submit" value="Create poll" />
  </form>
  <div id="result" hidden>
    <p>Your poll <strong>:poll_title</strong> is ready!</p>
    <label for="pollurl">Poll URL</label>
    <input type="text" id="pollurl" name="pollurl" value="<?= $app_url ?>:poll_url" />
    <label for="deleteurl">Delete URL</label>
    <input type="text" id="deleteurl" name="deleteurl" value="<?= $app_url ?>:delete_url" />
    <a class="button" href=":poll_url">See the poll!</a>
  </div>
</main>

<template id="choice">
  <input type="text" id="choice-:id" placeholder="Another choice" required />
  <button type="button" class="delete" tabindex="-1" title="Delete" aria-label="Delete">✕</button>
</template>

</body>