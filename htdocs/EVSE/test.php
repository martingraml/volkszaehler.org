<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tutorial: Hello Dojo!</title>
</head>
<body>
    <h1 id="greeting">Hello</h1>
    <!-- configure Dojo -->
    <script>
        // Instead of using data-dojo-config, we're creating a dojoConfig
        // object *before* we load dojo.js; they're functionally identical,
        // it's just easier to read this approach with a larger configuration.
        var dojoConfig = {
            async: true,
            // This code registers the correct location of the "demo"
            // package so we can load Dojo from the CDN whilst still
            // being able to load local modules
            packages: [{
                name: "demo",
                location: location.pathname.replace(/\/[^/]*$/, '') + '/demo'
            }]
        };
    </script>
    <!-- load Dojo -->
    <script src="//ajax.googleapis.com/ajax/libs/dojo/1.10.3/dojo/dojo.js"></script>
 
    <script>
        require([
            'demo/myModule'
        ], function (myModule) {
            myModule.setText('greeting', 'Hello Dojo!');
 
            setTimeout(function () {
                myModule.restoreText('greeting');
            }, 3000);
        });
    </script>
</body>
</html>
