CSY2089 Assignment 2 - Notes

Default staff/admin login:
Username: admin
Password: letmein

Default client login:
Username: hospitalclient
Password: letmein

CSY2089 Assignment-2

Run:
  docker compose down -v
  docker compose up -d

Public site:
  http://localhost:8000

Admin:
  http://localhost:8000/admin
  username: admin
  password: letmein

Client:
  http://localhost:8000/admin/index.php?action=clientLogin
  username: hospitalclient
  password: letmein

Testing inside Docker:
  docker compose exec php sh
  cd /as2/jobs/public
  php vendor/bin/phpunit tests


Implemented feature checklist:
1. Copyright year updated dynamically using date('Y').
2. Careers Advice page added.
3. Categories in public navigation and jobs page load dynamically from the database.
4. Jobs can be archived and reposted from admin without deleting them.
5. Admin jobs page shows category, date received/dateAdded and filter options.
6. Customers can filter jobs by title and location.
7. Staff/admin accounts replace the single shared password.
8. Client accounts can be managed by staff/admin.
9. Clients have restricted access and can only edit/view applicants for their own jobs.
10. Home page displays the five jobs closing soonest.
11. Contact enquiry form saves enquiries to the database; admin can view and mark them complete with the staff member recorded.

Code quality improvements:
- Autoloader used for namespaced classes.
- Controllers used for jobs, categories, users, clients and enquiries.
- DatabaseTable abstraction used instead of repeating SQL everywhere.
- Shared public and admin layout templates reduce repeated HTML.
- import.sql includes all tables and test data.

Syntax check:
All PHP files were checked using php -l and no syntax errors were reported.
