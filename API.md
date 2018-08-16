# VerlainePoll's API

## Methods

### Create a poll
```
    POST /polls
```

| Field          | Description                          | Optional   |
| -------------- | ------------------------------------ | ---------- |
| `title`        | The question.                        | no         |
| `options`      | All the options. Array of strings.   | no         |
| `settings`     | A Settings object.                   | yes        |

Return a Poll with `delete_token`.

### Retrieve a poll

```
GET /polls/:id
```

Return a Poll.

### Vote

```
POST /polls/:id/vote
```
| Field          | Description                                  | Optional   |
| -------------- | -------------------------------------------- | ---------- |
| `options`      | Options you want to vote for. Array of ids.  | no         |

Return a Poll.

### Delete a poll

```
DELETE /polls/:id/:token
```

Return a Poll.

## Entities

### Poll

| Attribute          | Description                          | Nullable   |
| ------------------ | ------------------------------------ | ---------- |
| `id`               |                                      | no         |
| `title`            | The question.                        | no         |
| `options`          | All the options. Array of Options.   | no         |
| `settings`         | A Settings object.                   | no         |
| `creation_date`    | Creation date.                       | no         |
| `delete_token`     | Deletion token.                      | yes        |

### Options

| Attribute          | Description                          | Nullable   |
| ------------------ | ------------------------------------ | ---------- |
| `label`            | The option.                          | no         |
| `votes`            | Numbers of votes.                    | yes        |

### Settings

| Attribute          | Description                                     | Nullable   |
| ------------------ | ----------------------------------------------- | ---------- |
| `unique_ip`        | One vote per IP address. Boolean.               | yes        |
| `multiple_choices` | Allow multiple choices in one vote. Boolean.    | yes        |
