# ProcessMaker Marketing and Sales Triggers: Object Oriented Classes

## Introduction

This repository contains object-oriented classes tailored for the marketing and sales process of a ProcessMaker project. These classes encapsulate distinct functionalities related to various stages of the sales, marketing, and post-sales processes, ensuring modular and maintainable code.

## Features

- **Object-Oriented Design:** The classes adhere to object-oriented principles, allowing for scalability, maintainability, and reusability.
- **Modular Structure:** Each class represents a distinct entity or functionality, making it easy to manage, modify, and extend.
- **Database Integration:** The classes are equipped with methods for database interactions, facilitating efficient data storage and retrieval.

## Included Classes

- **Marketing:** Manages marketing campaigns, promotions, and target audiences.
- **Sale:** Handles the sale transactions, including the recording of sales data and interactions with customers.
- **Selling:** Represents the process of selling a product or service, including tracking and managing the sales pipeline.
- **Claim:** Manages customer claims, including tracking, resolving, and reporting on claim statuses.
- **Implementation:** Deals with the implementation of sold services or products, including timelines, stages, and milestones.
- **Invoice:** Represents an invoice, with functionalities to manage billing, payments, and other financial aspects.

## Getting Started

1. **Prerequisites:** Ensure PHP is installed on your server and you have access to a MySQL database.
2. **Installation:** Clone the repository and include the required classes in your ProcessMaker triggers.
3. **Usage:** Instantiate the desired classes and utilize the methods provided to interact with the database and manage different aspects of your sales and marketing processes.

## Example Usage

```php
require_once ("classes/class.invoice.php");
$invoice = new Invoice();
$invoice->insert_invoice($list, $sellingObject, $owner, $submitDate);
```
