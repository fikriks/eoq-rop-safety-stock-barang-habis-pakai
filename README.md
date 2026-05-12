# EOQ, ROP, and Safety Stock for Consumables

## Project Context
Inventory management system for consumables (*barang habis pakai*) implementing **EOQ**, **ROP**, and **Safety Stock** methodologies. Built for the **Kantor Cabang Dinas Pendidikan Wilayah X Provinsi Jawa Barat**.

## Features
- **Dashboard:** Real-time summary of stock levels and inventory analysis.
- **Master Data:** Management of Items, Kodering (Accounting Codes), Prices, and Suppliers.
- **Transactions:** Automated stock adjustment for incoming and outgoing goods.
- **Inventory Analysis:** Automatic calculation of:
  - **EOQ (Economic Order Quantity):** Optimal order size to minimize costs.
  - **ROP (Reorder Point):** Stock level to trigger new orders.
  - **Safety Stock:** Buffer stock calculated using Standard Deviation Demand for accuracy.
- **Historical Analysis:** Monthly and yearly analysis with 12-month moving average prediction.
- **Reports:** Printable stock reports and transaction history.

## Technical Stack
- **Framework:** CodeIgniter 4.x
- **UI Framework:** Bootstrap 5
- **Style:** Simple Minimalism Flat (Neobrutalist) - Black & White, high contrast, sharp corners.
- **Language:** PHP 8.2+
- **Database:** MySQL/MariaDB

## Getting Started

### Prerequisites
- PHP 8.2+ with `intl`, `mbstring`, `json`, `mysqlnd`, and `libcurl` extensions.
- Composer.

### Installation
1.  **Clone the repository**
2.  **Install Dependencies:**
    ```bash
    composer install
    ```
3.  **Environment Configuration:**
    ```bash
    cp env .env
    ```
    Configure your database and `app.baseURL` in `.env`.
4.  **Run Migrations:**
    ```bash
    php spark migrate
    ```

### Running the App
```bash
php spark serve
```
Visit `http://localhost:8080`.

## Documentation
UML diagrams are available in the `docs/` folder in `.drawio` format:
- `er_diagram.drawio`
- `class_diagram.drawio`
- `use_case_diagram.drawio`
- `activity_diagram.drawio`
- `sequence_diagram.drawio`

## License
MIT
