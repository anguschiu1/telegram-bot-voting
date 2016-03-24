# Telegram bot for voting

Modified from `hellobot.php`

## Setup

1. Update the `config.php`
2. If `DEBUG` is `true`, it will write some debug information to 
`DEBUG_FILE_NAME`.  Please assign _write_ privileges to the 
`apache2` user.
3. Set up the webhook.  If use self-signed certificate, please set it
by other means (e.g. `curl -i -X POST -H "Content-Type: multipart/form-data" -F 
"certificate=@PUBLIC_KEY.pem" -F "url=https://MY_DOMAIN.COM/pollbot.php" 
https://api.telegram.org/BOT_TOKEN/setWebhook`)
4. Run

## TODO

[ ] One record for one user only
[ ] Input validation
[ ] Error handling (DB failed, )
[ ] Support English & Chinese
[ ] More questions? (e.g. When do you vote?  Which district? etc)
[ ] Additional user validation / checking
