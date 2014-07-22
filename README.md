# Symfony2 workshop

## Workshop goals

The goal of this demo application, is to start using the Symfony2 components in a legacy application.
Once the components have been studied separately, the application can be modified to use the
full-stack framework.

**NOTE:** This application is just a starter, this code is in no way production code.

This is a web application to share e-books in .pdf format, users win or loose points by using
the application.

This application has two main roles, a reader and an administrator. The reader perfoms the following
actions.

* Search books by title and author.
* Share its own books (It adds 15 points for each book).
* Download a book (This action cannot be done with less than 10 points). Each time a reader
downloads a book 2 points are used).
* Star a book (It adds 5 points).
* Write a book review. Reviews are moderated by the administrator, if a review is published
the reader wins 10 points.
