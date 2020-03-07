# Cost Forecast

The aim of this test is to define your expertise in different areas of programming: architecture, OOP, quality of code, tools usage, devops and software engineering best practices.

## Getting Started

Clone or download to your localhost

### Prerequisites

Download XAMPP or WAMPP to setup your localhost environment

### Installing

- Put the code in your root directory
- Run the web server
- Access via http://localhost/lms/

## Running the application

Input parameters:
- Current Number of study per day (we consider they are evenly distributed)
- Number of Study Growth per month in %
- Number of months to forecast

How to calculate the cost:
- RAM is one of the costlier components. We only need to have enough RAM for one day of study. 1000 studies require 500 MB RAM. The cost of 1GB of RAM per hour is 0.00553 USD
- Studies are kept indefinitely. 1 study use 10 MB of storage. 1 GB of storage cost 0.10 USD per month.


## Deployment

You may use Jenkins to deploy your code to production


## Authors

* **Felixander Loetama** - *Initial work* - [archeons](https://github.com/archeons)


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* This code is used for Lifetrack Medical Systems

