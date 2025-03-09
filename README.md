# Лабораторная работа №3. Массивы и Функции

## Цель работы
Освоить работу с массивами в PHP, применяя различные операции: создание, добавление, удаление, сортировка и поиск.  
Закрепить навыки работы с функциями, включая передачу аргументов, возвращаемые значения и анонимные функции.

---

## **Условие**
### Задание 1. Работа с массивами
Разработать систему управления банковскими транзакциями с возможностью:
- добавления новых транзакций;
- удаления транзакций;
- сортировки транзакций по дате или сумме;
- поиска транзакций по описанию.

---

### **Задание 1.1. Подготовка среды**
1. **Убедитесь, что у вас установлен PHP 8+.**
2. **Создайте новый PHP-файл `index.php`.**
3. **Включите строгую типизацию в начале файла:**
   ```php
   <?php
   declare(strict_types=1);
   ```

---

### **Задание 1.2. Создание массива транзакций**
Создайте массив `$transactions`, содержащий информацию о банковских транзакциях.  
Каждая транзакция представлена в виде ассоциативного массива с заданными полями.

**Массив:**
```php
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
```

---

### **Задание 1.3. Вывод списка транзакций**
Используйте `foreach`, чтобы вывести список транзакций в **HTML-таблице**. 
(Полный код, соответсвующий заданию будет представлен ниже).

---

### **Задание 1.4. Реализация функций**
Создайте и используйте следующие **функции**:

**1. Вычисление общей суммы транзакций**
```php
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
```
Выведите сумму в конце таблицы (код таблицы будет представлен ниже).

**2. Поиск транзакции по части описания**
```php
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
```
<img width="346" alt="image" src="https://github.com/user-attachments/assets/fe80f6ca-4588-4078-a6cb-0a587d1ba62b" />

**3. Поиск транзакции по `id`**


Через `foreach`:

  ```php
     /**
    * Ищет транзакцию по ID.
    *
    * @param int $id Уникальный идентификатор транзакции.
    * @return array Найденная транзакция или пустой массив.
    */
         function findTransactionById(int $id) {
             foreach ($GLOBALS['transactions'] as $transaction) {
                 if ($transaction['id'] === $id) return $transaction;
             }
         
             return [];
         }
  ```
  


Через `array_filter()` (на высшую оценку).


 ```php
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
   ```
   

<img width="437" alt="image" src="https://github.com/user-attachments/assets/fee7fac4-038e-43c3-807c-6bf4496f0439" />

**4. Количество дней с момента транзакции**
```php
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
```
<img width="437" alt="image" src="https://github.com/user-attachments/assets/fee7fac4-038e-43c3-807c-6bf4496f0439" />

**5. Добавление новой транзакции**
```php
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
```
---

### **Задание 1.5. Сортировка транзакций**
1. **Сортировка по дате с использованием `usort()`**
```php
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
```
<img width="580" alt="image" src="https://github.com/user-attachments/assets/b448a982-cebf-4dae-8a39-aa90fd470fa2" />

2. **Сортировка по сумме (по убыванию)**
```php
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
```

<img width="537" alt="image" src="https://github.com/user-attachments/assets/ce3b5879-6f06-4586-9d4e-b9c9014947be" />

# **Таблица:**
```php
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
```
<img width="608" alt="image" src="https://github.com/user-attachments/assets/104142f4-ce3e-4bdb-98d4-cffdf83ab32d" />

---

## **Задание 2. Работа с файловой системой**
1. **Создайте папку `image/`** и добавьте **20-30 изображений `.jpg`**.
2. **Создайте `index.php`** для отображения галереи.

**Пример кода:**
```php
<?php

/**
 * Получает список изображений из указанной директории.
 *
 * @param string $directory Путь к папке с изображениями.
 * @return array Массив имен файлов изображений.
 */
function getImagesFromDirectory(string $directory): array {
    // Проверяем, существует ли папка
    if (!is_dir($directory)) {
        return [];
    }

    // Получаем список файлов
    $files = scandir($directory);

    // Фильтруем только файлы .jpg и .jpeg
    return array_filter($files, function($file) use ($directory) {
        return is_file($directory . $file) && preg_match('/\.(jpg)$/i', $file);
    });
}

$dir = '../image/';

// Получаем список изображений
$images = getImagesFromDirectory($dir);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея изображений</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        header, footer {
            padding: 10px;
            background-color: #222;
            color: white;
            margin-bottom: 20px;
        }
        nav {
            margin: 10px;
        }
        nav a {
            text-decoration: none;
            color: white;
            margin: 0 15px;
            font-weight: bold;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }
        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .gallery img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<header>
    <h1>Галерея картинок</h1>
    <nav>
        <a href="#">About Dogs</a> | 
        <a href="#">News</a> | 
        <a href="#">Contacts</a>
    </nav>
</header>

<div class="gallery">
    <?php
    // Вывод изображений в галерею
    foreach ($images as $image) {
        echo "<img src='$dir$image' alt='Dog Image $image'>";
    }
    ?>
</div>

<footer>
    <p>USM © 2025</p>
</footer>

</body>
</html>
```

---
# **Результат:**
<img width="1458" alt="image" src="https://github.com/user-attachments/assets/6b95f4c3-0c37-46c7-9db8-37190d12d860" />

## **Документация кода**
Код должен **соответствовать стандарту PHPDoc**:
- Описывайте **каждую функцию** (`@param`, `@return`).
- **Комментарии** должны быть понятными и четкими.

---

## **Контрольные вопросы**
1. **Что такое массивы в PHP?**  
   Массив в PHP — это структура данных, позволяющая хранить несколько значений в одной переменной. Массивы могут быть индексированными, ассоциативными и многомерными.

2. **Каким образом можно создать массив в PHP?**  
   Массив можно создать с помощью `array()` или `[]`. Например, `$arr = [1, 2, 3];` — индексированный массив, а `$arr = ["name" => "John"];` — ассоциативный массив.

3. **Для чего используется цикл `foreach`?**  
   Цикл `foreach` используется для перебора элементов массива без необходимости отслеживать индексы. Он автоматически извлекает ключи и значения массива.

---

