<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>API Documentation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.46.0/swagger-ui.min.css" integrity="sha512-UGwuz6ImuVpwz60X6YbV7z5ZfSOfiENcFkFDUDvQ2WkD0f/Dy4b4A1IY/+02W0sZtUp3Gq3lLgzvO8WwRyBxFQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.46.0/swagger-ui-bundle.min.js" integrity="sha512-lc7KudQh1uV7RtpIVC67uV7hzH3/wk3o7mJr+uXfVjKk2A1mpJ95RfbZ+UpKjMCRqOuq7VJvzKUnX0Ae+Itt0g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.46.0/swagger-ui-standalone-preset.min.js" integrity="sha512-ZvS9YlIXU6JF3zg5U6vgh4ZEDBwqp4GQW1RmKLM9sy2+hfn0I+Fjzty8vrgjmzy6afBnygI+fwW0x8c1BIFdXw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        window.onload = function() {
            const ui = SwaggerUIBundle({
                url: "{{ url('api/documentation/json') }}",
                dom_id: '#swagger-ui',
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                layout: "BaseLayout"
            });
        }
    </script>
</body>
</html>
