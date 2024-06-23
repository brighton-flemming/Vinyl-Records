# Vinyl-Records


## Description

This is a web application for managing a vinyl record collection. It's built with Symfony and Twig, and it includes features like viewing the collection, adding new vinyls, deleting vinyls, and searching the collection.

## Installation

1. Clone the repository: `git clone https://github.com/brighton-flemming/Vinyl-Records`
2. Navigate to the project directory: `cd vinyl_records`
3. Install dependencies: `composer install`
4. Start the server: `symfony server:start`

## Usage

Open your web browser and navigate to `http://localhost:8000` to start using the application.

## Features

- **View Collection**: View all the vinyls in your collection.
- **Add Vinyl**: Add a new vinyl to your collection.
- **Delete Vinyl**: Remove a vinyl from your collection.
- **Search**: Search your collection by the record name or artist name.

## Technical Details

This application is built using the Symfony PHP framework and follows the MVC (Model-View-Controller) design pattern. Here's how it accomplishes its main tasks:

- **Symfony Application**: The application was created using the Symfony CLI command `symfony new vinyl_records`. This sets up a new Symfony project with the basic directory structure and configuration files.
- **Controllers**: Controllers are PHP classes that handle HTTP requests. They're stored in the `src/Controller` directory. Each public method in a controller class can be a controller action, which is a function that handles a specific route.
- **Twig**: Twig is used to create dynamic HTML templates for the views. In the controllers, a Twig template is rendered using the `render` method, passing in any variables that the template should have access to.
- **jQuery**: jQuery is used to add interactivity to the site. It's included in the project via a CDN and used in the `delete.html.twig`  template.
- **Doctrine**: Doctrine is used as the ORM (Object-Relational Mapping) to interact with the database using PHP objects instead of SQL queries.
- **Forms**: Symfony's form component is used to create forms and handle form submissions. The form data is validated before it's processed.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

MIT
