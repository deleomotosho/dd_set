Needs: Composer, PHP 5.4+

To run:
Create database (I used `sandbox` as table name, see `.env` file for credentials)
`composer install` (sets up the framework)

`php artisan migrate` (migrates the database and all)

visit: `http://localhost/` to load files and do analysis (files and automatically recognized)

----------------------------------------------------------

Challenge: 

This exercise involves file IO, SQL, and basic HTML.  You will be finding
statistical information about several ads.

The file `ad-stats.csv` describes daily ad stats.  For each date, there may be
up to one row per ad.  Each row has the following fields, in order:
- Ad ID [int] - refers to a particular advertisement
- Date [date] - the day that the stats are for
- Daily Views [int] - the number of times that the ad was shown that day

Each row in the `leads.csv` file describes someone who clicked on an ad:

- Lead ID [int] - unique to each row
- Date of Birth [date] - the day that the person was born
                         - Ad ID [int] - refers the ad that the person clicked
                         - State [string] - the US state where the person lives
                         - Created At [datetime] - the date/time when the person clicked the ad

                         Each row in `orders.csv` describes an order placed by one of the leads:

                         - Order ID [int] - unique
- Lead ID [int] - refers to the lead who placed the order
- Unit Price [decimal] - the price of one unit
- Quantity [int] - how many units the order is for
- Shipping [decimal] - the cost of shipping the order

Your first task is to import the daily ad stats, leads, and orders into an SQL database.

Then write a script that queries your database and outputs an HTML table with
the following columns:

- Ad ID
- All-time Total Views
- All-time Click Through Rate %
- All-time Conversion Rate %
- All-time Total revenue
- All-time Average Customer Age (for leads that clicked the ad)
- All-time Best State (State with the most conversions)
- All-time Worst State (State with the least conversions)

There should be exactly one row per ad. Sort the rows by conversion rate, with
the best at the top.

The "click-through rate" of an ad is the number of leads who clicked it divided
by the number of times the ad was viewed.

For example:  Ad X has 1000 views and 50 clicks.  The click through rate of ad X
is .05 (= 1000 / 50).

A "conversion" is a sale.  An ad "converts" whenever a lead makes at least one purchase after viewing it.  If a lead makes more than one purchase after viewing
the ad, it still only counts as one conversion.

The "conversion rate" for an ad is the number of its conversions divided by the
number of times it was viewed.

For example:  1000 people view ad X.  Of those 1000 people, 98 people click on
the ad.  Of those 98 leads, 35 went on to purchase at least one item.  The
conversion rate for ad X is .035 (= 1000 / 35).

An order's revenue is equal to its unit price times its quantity plus its
shipping (revenue = unit price * quantity + shipping).

An ad's total revenue is equal to the sum of the revenue of all the orders
placed by leads who clicked that ad.

Review:

- There may be up to one daily ad stats row for each ad id and date
- Not every lead has placed an order.
- ad click through rate = number of leads / views
- ad conversions = number of orders placed by leads who clicked the ad
- ad conversion rate = conversions / views

When you submit your code, include how you went about creating the database
tables.  You can provide a dump of the schema, or if you wrote a script to setup
the database, provide the script.  Also include the script you used to import
the csv file data into the database.  If you didn't use a script to import,
describe briefly how you did it (via command line, GUI workbench program,
manually entered, etc.)  

Finally, be sure to include the output of your program.

At Direct Digital, virtually all of our back-end code is written in PHP and
MySQL.  However, for this problem you can use whichever languages you want.
