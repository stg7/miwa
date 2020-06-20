# miwa
minimal web analytics is a small php script that is capable of logging user statistics.

Here the focus was not to make something similar to google analytics or Matomo, the general idea was to make something that is super lightweight and small.

# Usage

Copy the script `glo.php` to a path on a https webserver with php and sqlite, here it is important that the path of this script does not match any blocking rule of common ad blockers, e.g. `log.php` does not work, or `stats/..`.

Moreover change the APIKEY inside the `glo.php` and also in the javascript code.

Afterwards copy the following code to your page header (that is hopefully used in all subpages due to templating)

```
  <script type="text/javascript">
    var src = "<URL/AND/PATH/TO/SCRIPT/>/glo.php?key=<API_KEY>&p=" + JSON.stringify({"url": window.location.href});
    img = document.createElement('img');
    img.src = src;
    img.style.visibility = "hidden";
    document.body.appendChild(img);
  </script>
```

`<URL/AND/PATH/TO/SCRIPT/>` needs to be changed to your public server.
Here loading an image is simulated, this should work in most cases.

The script stores in a sqlite3 database the following values for a request:

* ip_address
* user_agent: client user agent
* page (that is the URL)
* time of the request
