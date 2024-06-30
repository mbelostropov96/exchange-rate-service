SELECT r.user_name, r.book_author, book_names
FROM (
    SELECT CONCAT(u.first_name, ' ', u.last_name) AS user_name, b.author AS book_author, GROUP_CONCAT(b.name) AS book_names
    FROM books AS b
    INNER JOIN user_books AS ub
        ON b.id = ub.book_id
    INNER JOIN users AS u
        ON u.id = ub.user_id
    WHERE u.birthday
        BETWEEN DATE_ADD(UTC_DATE(), INTERVAL -17 YEAR) AND DATE_ADD(UTC_DATE(), INTERVAL -7 YEAR)
        AND DATEDIFF(ub.return_date, ub.get_date) < 14
    GROUP BY ub.user_id, b.author
    HAVING COUNT(b.author) = 2
) AS r
