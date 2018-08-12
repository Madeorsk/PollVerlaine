<body class="home">
<script src="/static/js/fetch.min.js"></script>
<script src="/static/js/new.js"></script>

<h1>Poll Verlaine</h1>
<main>
  <form action="#" id="newpoll">
    <input type="text" name="title" placeholder="What do you want to ask?" />
    <div id="choices">
    </div>
    <button type="button" id="add-choice">New choice</button>
    <input type="submit" value="Create poll" />
  </form>
  <div id="result" hidden>
    <p>Your poll <strong>:poll_title</strong> is ready!</p>
    <input type="text" name="pollurl" value="<?= $app_url ?>:poll_url" />
    <a class="button" href=":poll_url">See the poll!</a>
  </div>
</main>

<template id="choice">
  <input type="text" id="choice-:id" placeholder="Another choice" />
  <button type="button" class="delete" tabindex="-1" title="Delete" aria-label="Delete">✕</button>
</template>

</body>