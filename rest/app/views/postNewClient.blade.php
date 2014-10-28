<html>
  <head>
    <title>Post Client</title>
  </head>
  <body>
    {{var_dump($input)}}
    What's the client's name?
    <form method="post" action="/registerClient/">
      <input name="name" placeholder="name" />
      <input type="submit" value="submit" />
    </form>
  </body>
</html>