# Basepin Repair Logs Application

A specialized, full-stack database application designed to record, track, and analyze industrial hardware diagnostics and component repair logs. Built with an agile, modular architecture, the system provides engineering and maintenance teams with a centralized administration dashboard that serves as a single source of truth for equipment service histories.

## Key Features
* Detailed Diagnostic Logging: Captures comprehensive technical records, including precise fault descriptions, diagnostic steps, error codes, and testing results.
* Component Tracking & Replacement: Tracks exact inventory and part allocations, documenting hardware replacements, serial numbers, and component costs.
* Historical Trend Analysis: Stores chronological service data to help engineering teams identify recurring faults, evaluate hardware stability, and plan preventive maintenance.
* Scalable Layout Architecture: Implements efficient backend data pagination and high-contrast table grids optimized to handle thousands of historical records smoothly.

## Tech Stack
* Backend & Server: PHP, MySQL (Local XAMPP Development Environment)
* Frontend: JavaScript, HTML5, CSS3 (High-Contrast Administration Layout)
* Core Design Principles: Modular Code Architecture, Strict Separation of Concerns, Structural Scannability

## System Workflow
1. Technician Assessment: A technician diagnoses a hardware issue and creates a new entry detailing the equipment type and specific fault symptoms.
2. Repair Documentation: The system updates to reflect active maintenance, logging the exact repair actions taken, time spent, and any replacement parts utilized from the warehouse.
3. Status Verification: Post-repair validation results are logged, updating the asset status to fully operational and archiving the record into the historical log.

## Database Schema & Performance
The MySQL database is structured to handle high-frequency logging using relational integrity and strategic indexing on asset identifiers and timestamp fields. This configuration enables seamless query execution, rapid text-filtering, and optimized automated reporting without risking local server lag.

## Local Installation & Setup
1. Clone this repository into your local development environment.
2. If executing via XAMPP, place the project directory inside the htdocs folder.
3. Import the database schema `.sql` file using phpMyAdmin.
4. Update the core database configuration file to match your local server port and user credentials.
5. Launch Apache and MySQL from the XAMPP Control Panel and navigate to localhost/Basepin-Repair-Logs in your browser.
