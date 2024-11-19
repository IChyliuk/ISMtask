<?php

/**
 * Return list of users.
 */
function get_users($conn)
{
    $statement = $conn->query('SELECT
                                    users.id AS user_id,
                                    users.name AS user_name
                                
                                FROM
                                    users
                                        LEFT JOIN
                                    user_accounts ON users.id = user_accounts.user_id
                                        LEFT JOIN
                                    transactions ON user_accounts.id = transactions.account_from
                                        OR user_accounts.id = transactions.account_to
                                WHERE transactions.trdate IS NOT NULL
                                GROUP BY
                                    users.name
                                ORDER BY
                                    users.id, user_accounts.id, transactions.trdate');
    return $statement->fetchAll();
}

/**
 * Return transactions balances of given user.
 */
function get_user_transactions_balances($user_id, $conn)
{
    $statement = $conn->query("SELECT
                                    strftime('%m', transactions.trdate) AS `month`,
                                    CASE
                                        WHEN transactions.account_from = user_accounts.id THEN -transactions.amount  -- если это отправитель
                                        WHEN transactions.account_to = user_accounts.id THEN transactions.amount    -- если это получатель
                                        ELSE 0
                                        END AS amount
                                FROM
                                    users
                                        LEFT JOIN
                                    user_accounts ON users.id = user_accounts.user_id
                                        LEFT JOIN
                                    transactions ON user_accounts.id = transactions.account_from
                                        OR user_accounts.id = transactions.account_to
                                WHERE users.id = $user_id
                                ORDER BY
                                    month;");
    return $statement->fetchAll();
}