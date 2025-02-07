# Library Api

a fire that is built to fulfill a technical test, with specified conditions laravel 11, PHP 8.2, Transaction and ORM

## Installation

for env just setting connection to database mysql and

```bash
  php artisan migrate
  php artisan db:seed
```

## Running API

To run tests, run the following command

```bash
  php artisan serve
```

## Api List

```text
GET     /api/category    {}
POST    /api/category    {"name":"Trilogi"}
GET     /api/category/1
PATCH   /api/category/1  {"name":"Trilogi"}
DELETE  /api/category/1


GET     /api/books        {}
POST    /api/books         {
    "title":"Naruto Shippuden",
    "qty":100,
    "category_id":1
}
GET     /api/books/1
PATCH     /api/books/1       {
    "title":"Naruto Shippuden",
    "qty":100,
    "category_id":1
}
DELETE  /api/books/1

POST    /api/borrow-book  {
  "borrow_id": 1,
  "book_id": 1
}

PATCH   /api/borrow-book  {
  "order_number": "ODR-xxxxx"
}

GET     /api/borrow-book/{order_number}
GET     /api/borrow-books?status=2
```

## Challange

-   pembuatan / penghapusan / perubahan kategori buku -> bisa menggunakan api category
-   pembuatan / penghapusan / perubahan buku -> bisa menggunakan api books
-   peminjaman buku -> POST /api/borrow-book
-   pengembalian buku -> PATCH /api/borrow-book
-   daftar buku yang dipinjam -> GET /api/borrow-books?status=2
