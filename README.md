## Workflow
First: Finish user login/registration in Laravel.
Second: Make sure your Baserow env/config and service code match your new table names.
Third: Build out controllers and routes for course/lesson/quiz flow.
Fourth: Add minimal progress tracking (just lesson_user).
Fifth: Create simple Blade views to display data.

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