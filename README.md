# Auto Responder to PR Bot
A bot that automatically comments to a new PR showing the live github.io link of the site. To use, edit the config array in *webhook.php* and make a new file called `secret.json` similar to the following:

```
{
  "githubkey": "your secret key you recorded in part 1",
  "token": "your secret access token"
}
```

More details here: http://codethejason.github.io/blog/webhook/
