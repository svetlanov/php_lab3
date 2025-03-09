<?php

declare(strict_types=1);

$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Payment for groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2021-02-15",
        "amount" => 75.50,
        "description" => "Dinner with friends",
        "merchant" => "Local Restaurant",
    ],
    [
        "id" => 3,
        "date" => "2022-06-17",
        "amount" => 775.90,
        "description" => "Breakfast with friends",
        "merchant" => "Restaurant",
    ],
    [
        "id" => 4,
        "date" => "2025-02-11",
        "amount" => 2175.50,
        "description" => "Shopping",
        "merchant" => "Shopping Center",
    ]
];

/**
 * Функция для подсчёта суммы всех транзакций
 * @param array $transactions массив транзакций
 * @return float сумма всех транзакций
 */

function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}

/**
 * Ищет транзакцию по части описания.
 *
 * @param string $descriptionPart Часть строки описания.
 * @return array Найденная транзакция или пустой массив.
 */

function findTransactionByDescription(string $descriptionPart) : array {
    foreach ($GLOBALS['transactions'] as $transaction) {
        if (strpos($transaction['description'], $descriptionPart) !== false) return $transaction;
    }

    return [];
}

// print_r(findTransactionByDescription("Pay"));

// function findTransactionById(int $id) {
//     foreach ($GLOBALS['transactions'] as $transaction) {
//         if ($transaction['id'] === $id) return $transaction;
//     }

//     return [];
// }

/**
 * Ищет транзакцию по ID.
 *
 * @param int $id Уникальный идентификатор транзакции.
 * @return array Найденная транзакция или пустой массив.
 */

function findTransactionById(int $id) {
    $callback = function ($transaction) use ($id) {
        return $transaction['id'] === $id;
    };
    return array_filter($GLOBALS['transactions'], $callback);
}

/**
 * Вычисляет количество дней с момента транзакции до текущей даты.
 *
 * @param string $date Дата транзакции в формате YYYY-MM-DD.
 * @return int Количество дней.
 */

function daysSinceTransaction(string $date) : int {
    $dateObj = new DateTime($date);
    $today = new DateTime();
    $interval = $dateObj -> diff($today);
    return (int) $interval->format('%a');
}

/**
 * Добавляет новую транзакцию в массив транзакций.
 *
 * @param int $id Уникальный идентификатор транзакции.
 * @param string $date Дата транзакции.
 * @param float $amount Сумма транзакции.
 * @param string $description Описание транзакции.
 * @param string $merchant Продавец или место покупки.
 * @return void
 */

function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    GLOBAL $transactions;
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant
    ];
}

/**
 * Функция для сортировки транзакций по дате (от старых к новым).
 *
 * @param array $a Первая транзакция.
 * @param array $b Вторая транзакция.
 * @return int Разница во времени между датами.
 */

function compareByDate($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
}

/**
 * Функция для сортировки транзакций по сумме (от большей к меньшей).
 *
 * @param array $a Первая транзакция.
 * @param array $b Вторая транзакция.
 * @return int Разница между суммами.
 */

function compareByAmount($a, $b) {
    return $b['amount'] - $a['amount']; // Сортировка по убыванию
}



?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <div>
            Поиск транзакции по описанию "Pay":
        </div>
        <div>
            <pre><?php print_r(findTransactionByDescription("Pay")); ?></pre>
        </div>
    </div>
    <br>
    <div>
        <div>
            Поиск транзакции по id "3":
        </div>
        <div>
            <pre><?php print_r(findTransactionById(3)); ?></pre>
        </div>
    </div>

    <br>
    <div>
        <div>
            добавление новой транзакции <pre>addTransaction(5, "2025-02-01", 699.99, "Make up products", "Make up Store");</pre>
        </div>
        <div>
            <pre><?php 
            addTransaction(5, "2025-02-01", 699.99, "Make up products", "Make up Store");
            print_r($GLOBALS['transactions']); 
            ?></pre>
        </div>
    </div>

    <br>
    <div>
        <div>
        Транзакции, отсортированные по дате:
        </div>
        <div>
            <pre>
            <?php 
            usort($transactions, 'compareByDate');
            print_r($transactions);
            ?>
            </pre>
        </div>
    </div>

    <br>
    <div>
        <div>
        Транзакции, отсортированные по сумме (по убыванию)::
        </div>
        <div>
            <pre>
            <?php 
            usort($transactions, 'compareByAmount');

            print_r($transactions);
            ?>
            </pre>
        </div>
    </div>

    <?php if (sizeof($transactions) > 0) { ?>
        <table border=1>
            <thead>
                <?php foreach ($GLOBALS['transactions'][0] as $key => $value) { ?>
                    <th><?= $key ?></th>
                <?php } ?>
                <th>Days after transaction</th>
            </thead>
            <tbody>
            <?php foreach ($GLOBALS['transactions'] as $transaction) { ?>
                <tr>
                <?php foreach ($transaction as $key => $value) {?>
                    <td><?= htmlspecialchars("{$value}") ?></td>
                <?php } ?>
                    <td><?= daysSinceTransaction($transaction['date']) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan=2>Total: </td>
                <td colspan=4> <?= calculateTotalAmount($GLOBALS['transactions']) ?></td>
            </tr>
            </tbody>
        </table>
    <?php } ?>
</body>
</html>