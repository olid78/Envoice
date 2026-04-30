# Envoice - Technical Documentation & User Guide

Envoice is a professional SaaS-style Invoice and Client Management web application built for freelancers and small business owners.

## 1. Technical Stack

| Layer | Technology |
|---|---|
| **Frontend** | HTML5, CSS3, Bootstrap 5 (UI Framework) |
| **Interactivity** | Vanilla JavaScript, AJAX (Fetch API) |
| **Charts** | Chart.js (Dashboard Visualization) |
| **Backend** | PHP 8.x (Object-Oriented Programming) |
| **Database** | MySQL 8.x |
| **Architecture** | MVC-inspired OOP Structure |

---

## 2. Database Schema

The database `envoice_db` consists of 5 relational tables:

- **`users`**: Stores business owner profiles and credentials.
- **`clients`**: Stores client contact and billing information.
- **`invoices`**: Main invoice records linked to users and clients.
- **`invoice_items`**: Line items for each invoice (Description, Qty, Price).
- **`payments`**: Payment transaction history for tracking balances.

### ER Diagram (Textual Representation)
```text
[Users] 1 ------- N [Clients]
  |                   |
  1                   1
  |                   |
  N ----------------- N [Invoices] 1 ------- N [Invoice_Items]
                          |
                          1
                          |
                          N
                      [Payments]
```

---

## 3. Setup & Installation (Localhost)

### Prerequisites
- PHP 8.0 or higher
- MySQL Server
- Web Server (Apache/Nginx) — *Recommended: XAMPP, WAMP, or Laragon*

### Step-by-Step Installation
1.  **Clone/Copy the Project:**
    Place the `Envoice` folder in your server's root directory (e.g., `C:/xampp/htdocs/Envoice`).
2.  **Database Setup:**
    - Open **phpMyAdmin**.
    - Create a new database named `envoice_db`.
    - Import the SQL file located at `Envoice/sql/schema.sql`.
3.  **Configuration:**
    - Open `Envoice/config/database.php`.
    - Update `DB_USER` and `DB_PASS` if they differ from your local MySQL settings (defaults are `root` and empty).
4.  **Launch:**
    - Navigate to `http://localhost/Envoice` in your web browser.

---

## 4. User Guide & Features

### A. Authentication
- **Sign Up:** Create a business account. Your "Business Name" and "Address" will appear on the invoices you generate.
- **Login:** Secure access to your private dashboard.

### B. Client Management
- Navigate to **Clients** to add your recurring customers.
- Each client stores a billing address which is automatically pulled into new invoices.

### C. Invoice Builder (Dynamic)
- Click **"Create Invoice"**.
- Select a client from the dropdown.
- **Live Calculation:** Add rows to the items table. The JavaScript engine calculates row totals, subtotal, and grand total (including tax) in real-time without page reloads.
- **Public Link:** Every invoice generates a unique, unguessable token. You can send this link to clients so they can view their invoice without logging in.

### D. Payment Tracking
- From the **Invoice Detail** page, click **"Record Payment"**.
- Support for partial payments: The "Balance Due" updates automatically.
- Once the balance reaches zero, the invoice status automatically flips to **"Paid"**.

### E. Dashboard Insights
- **Summary Cards:** See your total revenue and outstanding balances at a glance.
- **Revenue Chart:** A visual bar chart showing your earnings over time.

---

## 5. Folder Structure
- `/api`: AJAX endpoints for dynamic updates.
- `/assets`: CSS, JS, and uploaded images/logos.
- `/classes`: Core PHP OOP logic (User, Invoice, Client, Payment classes).
- `/config`: Database connection and app constants.
- `/includes`: Reusable UI components (Sidebar, Navigation).
- `/pages`: View files for all application routes.
- `/sql`: Database schema scripts.
