# PHP CRUD API

This PHP-based RESTful API provides CRUD (Create, Read, Update, Delete) operations for managing a list of items stored in a JSON file (`items.json`). The API supports filtering, adding, updating, and deleting items.

## Table of Contents

- [Getting Started](#getting-started)
- [API Endpoints](#api-endpoints)
  - [GET /items](#get-items)
  - [POST /items](#post-items)
  - [PUT /items](#put-items)
  - [DELETE /items](#delete-items)
- [Error Handling](#error-handling)
- [License](#license)

## Getting Started

### Prerequisites

- PHP 7.4 or later
- A web server with PHP support (e.g., Apache, Nginx)
- A tool for testing HTTP requests (e.g., Postman, cURL)

### Installation

1. **Clone or Download**: Obtain the PHP file and place it in your web server's root directory.

2. **Permissions**: Ensure the `items.json` file or its directory is writable by the web server user. The script will create this file if it doesn't exist.

3. **Configuration**: No additional configuration is needed. The script will handle data storage and retrieval automatically.

## API Endpoints

### GET /items

#### Description

Retrieve a list of items. Optionally filter items by the `name` query parameter.

#### Request

- **Method**: `GET`
- **URL**: `/items`
- **Query Parameters**:
  - `name` (optional): Filter items by name (case-insensitive).

#### Response

- **200 OK**: Returns a JSON array of items.
- **404 Not Found**: If no items are found or the file is empty.

