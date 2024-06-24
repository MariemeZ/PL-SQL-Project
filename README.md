# PL-SQL-Project

This project is a comprehensive implementation of various PL-SQL functionalities. It involves creating and managing a database, developing an interactive interface, and writing PL-SQL triggers, procedures, and functions to handle different database operations.


## Introduction
This project was developed as part of a course on PL-SQL. It aims to demonstrate the application of PL-SQL in creating and managing a relational database. The project includes:

- Creating tables and inserting data
- Developing an interactive GUI for database interaction
- Writing triggers to handle specific database operations
- Implementing stored procedures and functions for common tasks
- Prerequisites
- Oracle Database
- PL-SQL environment
- Basic understanding of SQL and PL-SQL

## Features
### 1. Table Creation and Data Insertion

Create Tables: Various tables were created to store data related to researchers, publications, and more.

Insert Data: Data was inserted into these tables based on provided specifications.

### 2. Triggers

Historical Data Maintenance: Before any modification or deletion in the chercheurs table, a copy of the information is stored in the historique_chercheurs table.

Capacity Check: Before assigning a researcher to a director, the system checks if the director has not exceeded their capacity of supervising 30 third-cycle students or 20 doctoral candidates.

Salary Protection: Prevents reduction of a researcher's salary.

Working Hours Enforcement: Ensures that updates to the database are only made during working hours (Monday to Friday, 8 AM to 6 PM).

### 3. Stored Procedures and Functions

Add Researcher: Procedure to add a new researcher.

Modify Researcher Profile: Procedure to update a researcher's profile, including grade, status, salary, and lab affiliation.

Extract Research Data: Function to extract and display the list of researchers with the highest number of publications in a given period for each faculty.

Delete Researcher: Procedure to remove a researcher from the database.
