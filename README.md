<h1>add tag to starred github repositories</h1>
<p>Using this api, you can get user-specific repositories and add tags to them for better identification</p>
<h2>Requirement</h2>
<p>To use this api, you must already have php and mysql installed on your system</p>
<h2>Installation</h2>
<p>First clone the code or download it.Then you need to do the following steps.</p>
<ul>
  <li>Open the .env file and enter your database settings.
    <span>These settings are as follows.
      DB_CONNECTION = mysql
      DB_HOST = 127.0.0.1
      DB_PORT = 3306
      DB_DATABASE = github
      DB_USERNAME = root
          DB_PASSWORD =
    </span>
  </li>
  <li>Then you need to create project tables with the php artisan migrate command in your database</li>
  <li>Then you can run the project with the php artisan serve command.</li>
  <li>You can also get the list of api urls with the php artisan route: list command</li>
</ul>
<h2>Usage</h2>
<p>You can see the list of repositories followed by a specific user of GateHub, add tags to repositories for better detection and regular classification.You can delete or edit the tag from the repositories. It is possible to add the tag individually or in multiples to a repository.You can also search for tags based on a part of their name and display repositories that have this tag</p>
