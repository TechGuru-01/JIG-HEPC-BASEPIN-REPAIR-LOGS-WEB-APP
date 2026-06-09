# Basepin Repair Logs Application

A specialized, full-stack database application designed to monitor, document, and analyze the operational status of industrial basepins. Built with an agile, modular architecture, the system provides engineering and maintenance teams with a centralized administration dashboard that serves as a single source of truth for equipment verification histories, visual inspections, and repair logs.

## Key Features
* Multi-Basepin Form Processing: Features an advanced, flexible input form capable of handling multiple basepin entries simultaneously, significantly reducing processing time for batch maintenance.
* Visual Verification Tracking: Supports image upload logs to store "Before" and "After" status photos for every inspected basepin, providing clear visual evidence of the component's state and any executed repairs.
* Detailed Diagnostic & Fix Logging: Captures comprehensive technical records, allowing technicians to explicitly document what fixes were applied or confirm that a basepin is cleared with no issues.
* Unique Component Serialization: Indexes records by the specific basepin number to ensure absolute asset traceability throughout its operational lifecycle.
* Historical Trend Analysis: Stores chronological inspection data to help engineering teams identify recurring faults, evaluate hardware stability, and plan preventive maintenance.
* Scalable Layout Architecture: Implements efficient backend data pagination and high-contrast table grids optimized to handle thousands of historical verification records smoothly.

## Tech Stack
* Backend & Server: PHP, MySQL (Local XAMPP Development Environment)
* Frontend: JavaScript (Dynamic Form Cloning), HTML5, CSS3 (High-Contrast Administration Layout)
* Core Design Principles: Modular Code Architecture, Strict Separation of Concerns, File System Image Mapping

## System Workflow
1. Initial Assessment & Intake: The technician selects the targeted basepin numbers via a dynamic multi-input form, documenting the initial physical state and uploading a "Before" image.
2. Condition & Fix Documentation: The form prompts the technician to specify the precise adjustments or repairs made. If a basepin requires no intervention and is deemed functional, it is explicitly logged as cleared.
3. Post-Repair Verification: The technician uploads an "After" validation image to visually confirm the basepin is stable and ready for operation.
4. Database Archiving: The backend processes the string inputs and moves uploaded images to secure local file paths, mapping the data to relational MySQL tables for permanent storage and audit transparency.

## Database Schema & Performance
The MySQL database is structured to handle high-frequency logging using relational integrity and strategic indexing on basepin numbers, status flags, and inspection timestamp fields. This configuration enables seamless query execution, rapid text-filtering, and optimized automated reporting without risking local server lag.

## Local Installation & Setup
1. Clone this repository into your local development environment.
2. If executing via XAMPP, place the project directory inside the htdocs folder.
3. Import the database schema `.sql` file using phpMyAdmin.
4. Create an upload directory within the project folder to host the "Before" and "After" basepin images, ensuring proper directory write permissions.
5. Update the core database configuration file to match your local server port and user credentials.
6. Launch Apache and MySQL from the XAMPP Control Panel and navigate to localhost/Basepin-Repair-Logs in your browser.
