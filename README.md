## Mini Form Builder

A simple form builder application built with the TALL stack (Tailwind CSS, Alpine.js, Laravel, Livewire), Laravel Breeze for authentication, PostgreSQL as the database, and Docker for easy setup and environment management.

## Features

- **Form Builder**: Create forms with various field types (text, select, etc.).
- **User Authentication**: Register, log in, and manage sessions using Laravel Breeze.
- **Responsive UI**: Responsive design by Tailwind CSS.
- **Real-time Interactions**: Dynamic form field additions/removals by Livewire.
- **Database Management**: PostgreSQL for storing form data and submissions.
- **Dockerized**: Simplified setup with Docker and Docker Compose.

## Requirements

- PHP >= 8.1
- Composer
- Node.js (for building assets)
- Docker (optional but recommended)
- PostgreSQL

## Installation

### 1. Clone the Repository

1. Clone the repo
   
   ```sh
   git clone [https://github.com/ShaniGajera1993/Mini-Form-Builder.git]
   ```
3. Copy the environment file & edit it accordingly
   ```sh
   cp .env.example .env
   ```
4. Generate an application key
   ```sh
   php artisan key:generate
   ```
5. Install the necessary dependencies
   ```sh
   composer install
   npm install
   npm run dev
   ```
6. Build and start the Docker containers
   ```sh
   docker compose up --build
   ```

## Screenshots

![first](https://github.com/user-attachments/assets/076b2e73-852d-448d-9d3b-5ec6b1cf4996)

![second](https://github.com/user-attachments/assets/425a1db9-1d8d-40b5-9f71-17617817322f)

![third](https://github.com/user-attachments/assets/55a1894d-5c97-4fad-a49d-cd91f736aaf7)

![fourth](https://github.com/user-attachments/assets/5586b50e-92dc-4db1-aec2-75a2cb1ca831)
