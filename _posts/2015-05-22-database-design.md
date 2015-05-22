---
layout: post
title: Relational Database Design
description: Conventions and strategies to create a schema that will grow with your application and organization.
tags: [technology, database, schema, back end, engineering]
author: ZumbaJustin
---

Schema design is something that is very important to any application where data is to be stored and retrieved.  It is also a topic that is often debated, controversial and discarded as something simple to be done during development.  However, Proper planning BEFORE development is done will help save a lot of time down the road.

Over my last 15 years in application development, I have been refining techniques, best practices and conventions with regard to designing database schemas so that they can be used in real world enterprise solutions.  In this article I will discuss some things I have learned so far and share my opinions and experiences.  The views expressed in this article are my own and may or may not reflect that of Zumba.

### Overview - The Basics
Wikipedia explains a relational database as a digital database whose organization is based on the relational model of data, as proposed by E.F. Codd in 1970. This model organizes data into one or more tables (or "relations") of rows and columns, with a unique key for each row. Generally, each entity type described in a database has its own table, the rows representing instances of that type of entity and the columns representing values attributed to that instance. Because each row in a table has its own unique key, rows in a table can be linked to rows in other tables by storing the unique key of the row to which it should be linked (where such unique key is known as a "foreign key"). Codd showed that data relationships of arbitrary complexity can be represented using this simple set of concepts.

That's a basic description of a relational database.  When designing a database schema, it is important to know the purpose of the application(s) in which it will be used and where the data may be transported at a later time.

### Where to begin
So, now that we have the basics covered and some definitions listed, it's time to dig in and start designing.  The first thing you need to do is decide (or learn) the purpose of the application.  You will also want to know if there is to be any reporting performed on the data and if there is a data warehouse that will process this data for further consumption at a later date. 

For the purpose of this article, we will assume that this is an application that handles products that are delivered to the end user digitally like an interactive book.  The following are some questions you will want to ask the product owners at the start of a project.  Most of questions should be asked in general for all aspects of the software design.

- Who is the audience of the application?
  - Who will be using the application and how?
- Are there administrative areas?
  - If so, will there be different statuses / states of items?
  - Do changes to these need to be monitored and logged?
  - Will there be a need to see real-time statistics?
- Does admin activity need to be logged and reported?
- Does regular user activity need to be logged and reported?
- Will there be a need for real-time reporting of user activity?
- Will the application need to interact with 3rd party systems?
- How long must data be stored to be compliant with any rules that must be followed?

There are other questions that may be more specific to the type of application.

### Naming Conventions
Just as coding standards and variable naming conventions are important, so are the naming of tables and columns.  This is one of the more controversial subjects on database design.  The interesting thing about "best practices" is they change and flip flop regularly.  So, as such, many will agree and disagree with what I view as proper naming.  Also, in some cases frameworks may require you to use certain naming conventions.  If you are bound by such restrictions, then try to use as much of this as possible.

So let's just get to it then.

#### Tables
The name should describe what is in the table and be very obvious to someone looking at the list of tables in your database.

- For tables that will map back to an object in code, use singular object names like '**product**', '**user**', '**color**', etc.
- Join Tables that facilitate 1 to many relationships will have the main object listed first and the attribute name second and joined together with an underscore (eg. '**product_language**', '**user_product**').
- Tables that store logged data will have a suffix of '_log' (eg. '**activity_log**').
- Tables that store historical states of objects or object/attributes will contain a suffix of '_hist' as in "history" (eg. '**product_status_hist**').
- When extending another table, typically a table in a framework that you want to be able to update without issue, you will add a meta table named the same as the table being extended with the suffix '**_meta**' (eg. '**user_meta**').
- If this application will be packaged within an existing database, then all tables should contain the same prefix.  The prefix should be small, kept to <= 3 characters + an underscore (eg. '**zba_**').

#### Columns
Names of your columns should be as self-explanatory as possible when someone is simply looking at a list of names without seeing the full structure of the table to see types.

- Try to avoid reserved words or words that are used in the SQL language.  For instance, don't name a description column 'desc'.  However, a suffix of '_desc' is fine.  More on that later.
- Most objects will have a "Name" element.  It is very easy to just call the column 'name' and be done with it.
  - However, if you use the table name (or portion of) and add the suffix of '**_name**', that will help to ensure that your query will not be ambiguous and that you will be able to pull data from a single query without having to specify an alias for each column name that is named generically.
  - In fact, any commonly used elements of an object should have their column name begin with the table so that the same simple usage can be achieved.  The convention for this would be to use '**TABLE_**' as a prefix to the generic name.
- When adding a column that is a foreign key to another table's id, it should be named as the foreign table name + '_id' (eg. in the product table, you would create the column '**color_id**' to reference the color table).
  - This format should be used for any foreign key columns.  The pattern is '**FOREIGN-TABLE_FOREIGN-TABLE-COLUMN**'.
- When adding a column that is used as a flag (1 or 0, true or false, etc.), it should contain the prefix: 'is_'.  So, an active flag would be named as '**is_active**', published flag would be '**is_published**'.

#### Constraints
Constraints are used to create restrictions on Foreign Keys and indexes or just to put a restriction on the data going into the column.

- **Foreign Key**: Use the prefix '**fk_**' and follow this format: '**fk_MAIN-TABLE_ref_FOREIGN-TABLE_FOREIGN-TABLE-COLUMN**'  (eg. '**fk_product_ref_color_id**').
- **Unique Index**: Use the prefix '**udx_**' and follow this format: '**udx_MAIN-TABLE_MAIN-TABLE-COLUMN**'   (eg. '**udx_product_product_name**').
- **Non-Unique Index**: Use the prefix '**idx_**' and follow this format: '**idx_MAIN-TABLE_MAIN-TABLE-COLUMN**'   (eg. '**idx_product_product_name**').
- Multi-column indexes follow the same convention as single column unique and non-unique, except, you just keep appending the column names that are used. 

### Defaults Conventions
Now that the naming conventions are covered, let's talk about some conventions when creating tables and how to put this to good use in your applications.

#### Standard Tables
Just about every web application will need one or all of the following tables.

- **user**: This table may already exist if you are using an existing framework.  
  - If using a framework, you may want to extend the user data in a table called '**user_meta**'.
- **role**: Just as you need users to use your system, you will want to differentiate those users. If using a framework in your application, this table may already exist.
- **status**: Something in your application will likely have a need for different statuses.  This is typically a small table and should likely make use of bit masks (discussed later).

There are other standard tables based on what type of application you are building.  **product** might be a another common table.  But if your app does not deal with products, this might not be needed. 

#### Standard Columns
- All tables should have the following column.
   - A primary key column named simply '**id**'.  This column can be simply a number or a large UUID string.  Unless there is a really good reason, the ID should generally be an integer of whatever size you think the table may grow.  The UUID can be another column in the table.
     - If numeric, It should be set to autoincrement (in databases that support it, or create a trigger and sequence in DBs such as Oracle to achieve the same thing).
     - If using a UUID string style, there is no autoincrement.  You will need to handle the generated value another way.
- Nearly all tables should have the following columns.  The only exception to this is when maintaining integrity is not important.
  - An '**is_active**' column with a default of 1 or true.  Instead of deleting from this table, you will set this to 0 or false.  This requires that your queries that select data be aware of the column and its purpose.
  - A '**created**' column with a default as specified below.  This should be set on row creation and not altered afterwards.
  - A '**modified**' column with a default as specified below.  This will contain a timestamp of when the most recent change was made to the record.

### Column Types

#### Basic Columns

- Flag columns should be stored as either boolean column types (if supported) or 1-byte integers where they will hold either a 0 or 1.
- Description or other columns that will hold markup or a lot of text should be some type of **TEXT** column based on what is appropriate for the length of the data and what is supported by your database.
- String values should be stored in VARCHAR type columns.  The length should be adequate to support the max length of the data.  I, personally, like using binary increments.  However, there is no benefit of doing so.  Just be sure it is large enough to support the data being stored.
- When adding a foreign key column, be sure to set its type to be the same as the column that it references.

#### Date and Time Columns
For columns that store date and time data, there are two ways to approach this.  Perform you calculations and procedures in the **database** or the **code**. 

- **database**
  - When offloading calculations and functions onto the database server, You will want to use datetime column types that are supported by the database server you are using.
  - At a minimum, you should choose a date and time column that that is as granular as 1 second.
  - You should use the same column type for all of your date-time columns so it will be obvious and predictable to anyone using the data.
  - For the '**created**' column, you will specify the default as whatever equates to NOW() for the column type chosen.
  - For the '**modified**' column, you will want to create a trigger that will set the value to whatever value was used for the default of the 'created' column ON UPDATE
  - The Date and Time column type should support timezone as well so that the time can be meaningful and re-produced reliably.
- **code**
  - When writing code that can be used on multiple databases or when you want to perform manipulations or calculations in the code or directly in the SQL, then you should use a numeric type to store the data.
  - The data should be stored as a unix timestamp (Number of seconds since epoch).  So the column must be at least as large as an INTEGER(10).
  - The Integer type should also be unsigned.
  - For the '**created**' column, you will specify the default as whatever equates to CURRENT_TIMESTAMP in the database or 0 and handle the value in the code.
  - For the '**modified**' column, you will want to have code that is centralized in whatever base object everything extends to set this value to be the current timestamp.
  - Timestamps should be set using UTC timezone with the proper offset for the timezone desired.  An additional column to store the timezone may be required as well.  

### Joining records
Join tables are the most common way to store 1-to-many relationships.  These tables typically just contain the IDs of both tables and the standard columns.  Sometimes, there may be some additional meta data.  But that is up to how they are being used.

Another option that works for attribute tables that have a relatively small number of records is to use **bit masks**.  To use a bit mask:
 
- Create your attribute table as normal except for the addition of 1 column called '**bitmask**'.
- The value would start at 2 for the first row and then go up by the power of 2 from there.
  - An easy way to achieve this is to create a trigger that will set the column value = the product of '**id**' x 2 AFTER INSERT if possible.
  - The data type of the bitmask column should be an unsigned integer that is large enough to account for all of your records as the power of 2 increases.
- Your main object table will then have a column called '**FOREIGN-TABLE_bitmask**' (eg. '**language_bitmask**').
  - To store the relationships, you will simply OR the languages bitmask values together and store that sum in the language_bitmask column.
    - Just a tip, you can simply add all of the values together and it will yield the same final number as OR-ing them all together.
  - To query the data (Example: pull product and language data), you would join language lang with product prod ON (prod.lang_bitmask & lang.bitmask = lang.bitmask).

The examples shown above are more pseudo code as I'm trying to not be database specific.  But you should be able to adapt them to your environment fairly easily.  Bitmasks cut down on the number of joins and will provide some performance improvements.  Just make sure the columns are indexed.

### Warehousing
One of the benefits of following these conventions and standards is that it will make the data very easy to be reported on and warehoused for Business Intelligence reporting and insights.  In order to tie data together from multiple applications and systems, a **Data Warehouse** is used.  There are many different commercial solutions for this in existence (Cognos, Oracle BI, Tableau, ...etc.).  However, they all basically store processed data in a database of their own.

The database in a data warehouse will not be designed the same as the database used in an application.  Multiple queries per second are not as important as data integrity.  The structure is set up in a way to facilitate the generation of reports as fast as possible while still maintaining the integrity of the data.

#### ETL
In order for the warehouse to collect data from many disparate systems, it uses what is called an **ETL** process.  **ETL** stands for **E**xtract, **T**ransform, **L**oad.  Essentially, what it does in a basic sense is 

1. Pull data from the application database.
2. Transform the data or parse it so that it will fit into its schema and be able to be used with the data from the other systems. 
3. Insert / Update records in the warehouse database with the newly transformed data.

#### Why Is This Relevant
The way that the ETL process determines what should be brought into the warehouse is based on multiple factors.  However, the main one is based on when data changes.  So columns like 'created' and 'modified' help to determine what records have changed since it last ran.  The 'is_active' column is used to help with letting the warehouse know when data is "deleted" (A soft delete).

Having a consistent numerical id column allows the warehouse to tie back records to the records in the application database tables.  The warehouse will use its own IDs, but will need to be able to keep track of changes in the application.  And the ID column is the best one to use.

### Conclusion
This article is a general guideline for schema design and is intended to be a starting point for application database design.  It should be extended and altered where necessary.  Following these guidelines will help to build a solid foundation for any application.  I hope this has been informative and/or thought provoking.

Thanks for reading.
