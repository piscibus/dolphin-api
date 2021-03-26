# Dolphin API

Dolphin is customer feedback management tool.

## Getting started

As a developer, to access the API endpoint locally, or to contribute the source-code, you need to:
1. Install Docker
2. Checkout to the `develop` branch.
3. Use `sail up` command to start the services. Click to find [more information about sail](https://laravel.com/docs/8.x/sail).

### troubleshooting
If you are running docker on `windows 10` and it shows the following error message:
`docker: no matching manifest for windows/amd64 10.0.18363 in the manifest list entries.`
You can bypass it by running the Docker daemon in the experimental mode:
1. Right click Docker icon in the Windows System Tray.
2. Go to __Settings__ > __Daemon__ > __Advanced__ 
3. Set the `"experimental": true`.
4. Restart Docker.

## Code formatting
We are using PHP-CS-Fixer to auto format our code. To format your code run:

```
composer format
```

## Static code analysis 
We're using [Psalm](https://github.com/vimeo/psalm) for  a static analysis tool for finding errors in PHP.

To analyze your code run:
```
composer psalm
```

## License
The Dolphin software is open-sourced software licensed under the [LICENSE_NAME license](#).
