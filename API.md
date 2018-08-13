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

Return a Poll.

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
DELETE /polls/:id
```

Return a Poll.

## Entities

### Poll

| Attribute       | Description                          | Nullable   |
| --------------- | ------------------------------------ | ---------- |
| `id`            |                                      | no         |
| `title`         | The question.                        | no         |
| `options`       | All the options. Array of Options.   | no         |
| `settings`      | A Settings object.                   | no         |
| `creation_date` | Creation date.                       | no         |

### Options

| Attribute       | Description                          | Nullable   |
| --------------- | ------------------------------------ | ---------- |
| `id`            |                                      | no         |
| `label`         | The option.                          | no         |

### Settings

| Attribute       | Description                          | Nullable   |
| --------------- | ------------------------------------ | ---------- |
| `unique_ip`     | One vote per IP address. Boolean.    | yes        |
