# Secure Coding Rules: Database Operations & SQL Injection Prevention

This rule is **Always On** for database-related changes in this workspace.

## 1. Mandatory Prepared Statements & Parameter Binding
* **Rule**: You MUST use Parameterized Queries (Prepared Statements) for all database operations.
* **ORM/Query Builder**: Use Eloquent or Query Builder standard methods (e.g., `where()`, `find()`, `insert()`, `update()`, `join()`) which automatically use prepared statements.
* **Raw Queries Avoidance**: Minimize the use of raw SQL methods like `DB::raw()`, `whereRaw()`, `selectRaw()`, `orderByRaw()`, `havingRaw()`, and raw PDO queries.
* **Secure Bindings**: If you *must* use a raw query, you **MUST** pass parameters using bindings.
  * **❌ INCORRECT (SQL Injection Vulnerability)**:
    ```php
    $users = DB::select("SELECT * FROM users WHERE email = '" . $email . "'");
    $posts = Post::whereRaw("title LIKE '%" . $search . "%'")->get();
    ```
  * **✅ CORRECT (Prepared Statements)**:
    ```php
    $users = DB::select("SELECT * FROM users WHERE email = ?", [$email]);
    // Or using named bindings:
    $users = DB::select("SELECT * FROM users WHERE email = :email", ['email' => $email]);
    // Using Eloquent / Query Builder:
    $posts = Post::where('title', 'like', "%{$search}%")->get();
    // Using whereRaw with bindings:
    $posts = Post::whereRaw("title LIKE ?", ["%{$search}%"])->get();
    ```

## 2. Secure Exception Handling (No SQL Error Leaks)
* **Rule**: Never expose raw database or SQL exception details to the user interface.
* **❌ INCORRECT**:
  ```php
  try {
      // query
  } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()]); // LEAKS SQL structure, table names, or credentials
  }
  ```
* **✅ CORRECT**:
  ```php
  try {
      // query
  } catch (\Illuminate\Database\QueryException $e) {
      Log::error('Query failed', ['exception' => $e]);
      return response()->json(['error' => 'A database error occurred. Please try again later.'], 500);
  }
  ```
* **Note**: Let database exceptions bubble up to the global handler configured in [bootstrap/app.php](file:///Users/mac/clone%20walhi/walhi_larafel/bootstrap/app.php) unless you specifically need to handle them locally, in which case return a generic error message and log the details securely.

## 3. Environment Integrity
* **Rule**: Ensure `APP_DEBUG=false` in production env files (`.env`) to prevent default error pages (e.g. Ignition) from exposing database connection names, table structures, and parameters.
