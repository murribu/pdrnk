<html>
  <head>
    <title>Sign in</title>
  </head>
  <body>
    {{var_dump($test)}}
    Please sign in
    <form method="post" action="/auth/login">
      <input name="email" value="murribu" />
      <input name="password" value="asdf" />
      <input type="submit" value="submit" />
    </form>
  </body>
</html>