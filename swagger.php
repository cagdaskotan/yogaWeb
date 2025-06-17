<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Swagger UI</title>
  <link rel="stylesheet" type="text/css" href="libs/swagger-ui/dist/swagger-ui.css">
  <style>
    html { box-sizing: border-box; overflow-y: scroll; }
    *, *:before, *:after { box-sizing: inherit; }
    body { margin:0; background: #fafafa; }
  </style>
</head>
<body>
  <div id="swagger-ui"></div>

  <script src="libs/swagger-ui/dist/swagger-ui-bundle.js"></script>
  <script src="libs/swagger-ui/dist/swagger-ui-standalone-preset.js"></script>
  <script>
    window.onload = () => {
      const ui = SwaggerUIBundle({
        url: "api/swagger.json", // JSON dosyan buraya konulmalı
        dom_id: '#swagger-ui',
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIStandalonePreset
        ],
        layout: "StandaloneLayout"
      });
      window.ui = ui;
    };
  </script>
</body>
</html>