## Workflow
First: Finish user login/registration in Laravel.
Second: Make sure your Baserow env/config and service code match your new table names.
Third: Build out controllers and routes for course/lesson/quiz flow.
Fourth: Add minimal progress tracking (just lesson_user).
Fifth: Create simple Blade views to display data.



## Implementation Plan
2. Step-by-Step (Implementation Plan)
On each lesson page:

List all quizzes for that lesson.

Under each quiz, list all questions with radio/select/text input as needed.

Each quiz form has a Submit Quiz button.

When a quiz is submitted:

Save the user's answers and score for that quiz in the database.

Mark the quiz as completed for the user.

If all quizzes in this lesson are completed, enable the “Mark Lesson as Complete” button.

When a lesson is marked complete:

Update the lesson_user table as before.

Award points.

Progress tracking:

Show visual feedback: completed quizzes, completed lessons, daily/weekly/monthly stats.


## data system:
flowchart TD
  A[User (Browser)] -->|visits /register, /login| B[Laravel Auth] --> C[Auth Middleware]
  C --> D[/courses Route]
  D --> E[CourseController@index]
  E --> F[BaserowService.fetch('courses')]
  F --> G[Baserow API]
  G --> F
  F --> E
  E --> H[View: resources/views/courses/index.blade.php]
  H --> A

  A -->|click course| I[/courses/{id} Route]
  I --> J[CourseController@show]
  J --> K[BaserowService.fetch('modules')]
  K --> G
  K --> J
  J --> L[View: resources/views/courses/show.blade.php]
  L --> A

  A -->|select lesson| M[/lessons/{id} Route]
  M --> N[CourseController@lesson]
  N --> O[BaserowService.fetch('lessons'), fetch('tasks')]
  O --> G
  O --> N
  N --> P[View: resources/views/courses/lesson.blade.php]
  P --> A

  P -->|complete task| Q[POST /tasks/{id}/complete]
  Q --> R[CourseController@completeTask]
  R --> S[Progress Model -> local DB]
  S --> R
  R --> P


  ## Mariadb DB setup:
  # 1. Install MariaDB (if not installed)
sudo apt-get update
sudo apt-get install mariadb-server -y

# 2. Start MariaDB
sudo /etc/init.d/mariadb start

# 3. Set root password (each new workspace)
sudo mysqld_safe --skip-grant-tables &
mysql -u root

# --- In the MariaDB prompt, enter these SQL commands ---
FLUSH PRIVILEGES;
ALTER USER 'root'@'localhost' IDENTIFIED BY 'yourpassword';
FLUSH PRIVILEGES;
EXIT;

# 4. Restart MariaDB
sudo /etc/init.d/mariadb restart

# 5. Create your database
mysql -u root -p
# (Enter yourpassword when prompted)
# --- In the MariaDB prompt, enter: ---
CREATE DATABASE your_db_name;

# 6. Update Laravel .env file:
# (Set these variables in your .env file)
# DB_DATABASE=your_db_name
# DB_USERNAME=root
# DB_PASSWORD=yourpassword

# 7. Clear Laravel config cache
php artisan config:clear

# 8. Run migrations (optional)
php artisan migrate

  