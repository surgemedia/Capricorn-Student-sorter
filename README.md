# Capricorn-Student-sorter
a wordpress plugin to sort and store student photos.


##Folders
- `assets` this handles the js and scss for the plugin.
- `docs` this is this book
- `lib` Any libraries that are need eg (QR reader)
- `views` the admin pages that are seen inside wordpress.
- `views/actions` Any complex actions that happen on those pages. eg (Upload or read QR)


##Key Files
- `index.php` is the first file called by the plugin system. It sets up the upload folder, the menu and calls the pages.
- `webpack.config` handles all the css and js dependencies if any are used
- `package.json` handles and Npm dependencies you have like react.js



##Dataflow
![](capricorn-QR.png)