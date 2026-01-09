Community Event Volunteer Matching & Coordination System
Part 1: Initial Setup (The Environment)
Before the demonstration, the project must be hosted on a local server environment.
1.	Extract Files: Unzip the project folder and place it inside the htdocs directory (if using XAMPP) or www (if using WAMP).
2.	Start Services: Open your XAMPP/WAMP Control Panel and start Apache and MySQL.
3.	Database Setup:
o	Open your browser and go to localhost/phpmyadmin.
o	Verify a new database named volunteer_system.
4.	Verify Connection: Open db.php in a text editor and ensure the database name and credentials match your local setup.
Part 2: The Demonstration Workflow
First we have go to the website using the link http://localhost/lumos/home.html.
(Verify whether the files extracted are within the location C:\xampp\htdocs\lumos)
Step 1: Volunteer Registration (Building the Talent Pool)
•	Action: Go to localhost/your_folder/volunteer_register.html.
•	Demo Point: Register a new user named "Ajay".
•	Key Action: Select specific skills (e.g., "Security" and "First Aid") and pick an Available Date (e.g., 2026-01-20).
•	Explanation: "When the volunteer registers, the system doesn't just save their name; it catalogs their specific competencies and availability for our matching engine."
Step 2: Creating a Need (The Manager’s View)
•	Action: Go to localhost/your_folder/create_event.html.
•	Demo Point: Create an event titled "Community Marathon" set for the same date you picked for the volunteer (e.g., 2026-01-20).
•	Add Roles: Add a role for "Security" and "Logistics".
•	Explanation: "The manager defines the event and the specific roles required. This creates a search parameter for our intelligence engine."
Step 3: The Smart Matching Engine (The "Magic" Moment)
•	Action: After saving the event, the manager is redirected to the Matchmaking Dashboard (matchmaking.php).
•	Demo Point: Click "Search Matches" under the "Security" role.
•	Result: Ajay’s name will appear because his skills and date match perfectly.
•	Action: Click "Assign" next to John’s name.
•	Explanation: "The engine just performed a real-time check. It verified that John has the 'Security' skill, is free on this date, and isn't already working elsewhere."
Step 4: Fulfillment (Volunteer Confirmation)
•	Action: Go to the home page (home.html) and log in as the volunteer (John Doe).
•	Demo Point: You are taken to the volunteer_dashboard.php.
•	Result: You will see the invitation for the "Community Marathon."
•	Action: Click "Confirm Now".
•	Explanation: "This completes the cycle. The assignment status updates to 'Confirmed' in the database, giving the manager a reliable, final staff list."
Part 3: Key Technical Talking Points for the Assigner
If the person reviewing the zip file asks how it's built, highlight these:
•	Security: Passwords are never stored as text; they are secured using password_hash().
•	Responsiveness: The UI uses Bootstrap 5 and Glassmorphism CSS to ensure it looks professional on both mobile and desktop.
•	Real-Time Performance: The matching engine uses AJAX (Asynchronous JavaScript) via get_matches.php to fetch results without refreshing the whole page.
•	Relational Logic: The database uses JOIN statements to connect four different tables instantly, ensuring data integrity.
