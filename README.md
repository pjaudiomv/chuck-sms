# Chuck SMS

Sends random chuck norris quote text message when sending an txt with the word chuck in it to a twilio number. Will read it over voice as well.

### Installation

1) Download zip of the repository.
2) Run `composer install`
3) Set up a twilio account.
4) Add the twilio account sid and auth token info to `chuck.php`.
5) Upload everything to a server for hosting.
6) Provision a new phone number.
7) Point the voice and sms webhook to your https://your-web-server/chuck.php.  HTTP POST should be the method used.
8) `$keyword` is the trigger word that sends quote.
