Track
=====

A simple PHP web app created to demonstrate web programming to a colleague.

The app is a project management tool, different engineers are assigned to
various projects, called tracks, and work is assigned to them in those projects.
The status of the different tasks is tracked by the application.

The app does not use any framework. It shows how to manage logins, sessions
AJAX requests, HTML generation and a simple page layout.

The MySQL API, readily available in PHP is used to access the database.
Access to the database is via a module ( packaged as a .inc file ) and provides
a single point of contact to the storage for all pages in the app.

If I were writing the app today, I'd have used Smarty for HTML generation.
